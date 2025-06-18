<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Controller\Adminhtml\Oauth;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\EntityManager\EventManager;
use Upvado\ShopeeConnector\Api\Data\TokenInterface;
use Upvado\ShopeeConnector\Api\TokenRepositoryInterface;
use Upvado\ShopeeConnector\Exception\AuthenticationException;
use Upvado\ShopeeConnector\Model\TokenFactory;
use Psr\Log\LoggerInterface;
use Upvado\ShopeeClient\Client;

class Callback implements HttpGetActionInterface
{
    public function __construct(
        private readonly Client $client,
        private readonly TokenFactory $tokenFactory,
        private readonly TokenRepositoryInterface $tokenRepository,
        private readonly RedirectFactory $redirectFactory,
        private readonly ManagerInterface $messageManager,
        private readonly LoggerInterface $logger,
        private readonly Http $request,
        private readonly EventManager $eventManager
    ) {}

    public function execute(): Redirect
    {
        $redirect = $this->redirectFactory->create();
        $redirect->setPath('shopee_connector/account/index');

        try {
            $authorizationCode = $this->retrieveAuthorizationCode();
            $tokenResponse = $this->client->exchangeAuthorizationCodeForAccessToken($authorizationCode);
        } catch (AuthenticationException $authenticationException) {
            $this->logger->error('Authentication error during OAuth callback: ' . $authenticationException->getMessage());
            $this->messageManager->addErrorMessage(__('Authentication failed: %1', $authenticationException->getMessage()));
            return $redirect;
        }

        /** @var TokenInterface $token */
        $token = $this->tokenFactory->create();
        $token->setUserId($this->getUserIdFromToken($tokenResponse['access_token']));
        $token->setAccessToken($tokenResponse['access_token']);
        $token->setExpiresAt(time() + $tokenResponse['expires_in']);
        $token->setGrantType($tokenResponse['token_type']);
        $token->setRefreshToken($tokenResponse['refresh_token']);

        try {
            $this->tokenRepository->save($token);
            $this->messageManager->addSuccessMessage(__('Authorization successful. Your Shopee account is now connected.'));
        } catch (LocalizedException $localizedException) {
            $this->logger->error('Error saving OAuth token: ' . $localizedException->getMessage());
            $this->messageManager->addErrorMessage(__('Unable to save OAuth token: %1', $localizedException->getMessage()));
        }

        $this->eventManager->dispatch('shopee_connector_oauth_callback', ['shop_id' => $tokenResponse['shop_id']]);

        return $redirect;
    }

    private function getUserIdFromToken(string $token): int
    {
        return (int) strtok($token, '.');
    }

    private function retrieveAuthorizationCode(): string
    {
        $code = $this->request->getParam('code');

        if ($code === null) {
            throw new AuthenticationException(__('Missing authorization code'));
        }

        return $code;
    }
}
