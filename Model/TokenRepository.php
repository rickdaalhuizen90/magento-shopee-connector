<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Api\Data\TokenInterface;
use Upvado\ShopeeConnector\Api\TokenRepositoryInterface;
use Upvado\ShopeeConnector\Model\ResourceModel\Token as ResourceModel;
use Upvado\ShopeeConnector\Model\TokenFactory;

class TokenRepository implements TokenRepositoryInterface
{
    private readonly ResourceModel $resouce;

    public function __construct(
        private readonly TokenFactory $tokenFactory,
        ResourceModel $resouce
    ) {
        $this->resouce = $resourceModel;
    }

    /**
     * @inheritdoc
     */
    public function save(TokenInterface $token): TokenInterface
    {
        try {
            $this->resouce->save($token);
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to save token: %1', $exception->getMessage()));
        }

        return $token;
    }

    /**
     * @inheritdoc
     */
    public function get(string $accessToken): TokenInterface
    {
        $token = $this->tokenFactory->create();

        try {
            $this->resouce->load($token, $accessToken, 'access_token');
            if (!$token->getEntityId()) {
                throw new LocalizedException(__('No token found for the provided access token.'));
            }
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to retrieve token by access token: %1', $exception->getMessage()));
        }

        return $token;
    }

    /**
     * @inheritdoc
     */
    public function delete(TokenInterface $token): bool
    {
        try {
            $this->resouce->delete($token);
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to delete token: %1', $exception->getMessage()));
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function isExpired(TokenInterface $token): bool
    {
        return time() >= $token->getExpiresAt();
    }
}
