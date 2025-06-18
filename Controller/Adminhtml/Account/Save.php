<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Controller\Adminhtml\Account;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Upvado\ShopeeConnector\Api\AccountRepositoryInterface;
use Upvado\ShopeeConnector\Api\AttributeMappingRepositoryInterface;
use Upvado\ShopeeConnector\Api\CategoryMappingRepositoryInterface;
use Upvado\ShopeeConnector\Model\CategoryMappingFactory;
use Upvado\ShopeeConnector\Api\ShopRepositoryInterface;
use Upvado\ShopeeConnector\Model\Account;
use Upvado\ShopeeConnector\Model\AccountFactory;
use Upvado\ShopeeConnector\Model\AttributeMappingFactory;
use Upvado\ShopeeConnector\Model\Shop;
use Upvado\ShopeeConnector\Model\ShopFactory;
use Psr\Log\LoggerInterface;

class Save implements HttpPostActionInterface
{
    public function __construct(
        private readonly RequestInterface $request,
        private readonly AccountFactory $accountFactory,
        private readonly ShopFactory $shopFactory,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly ShopRepositoryInterface $shopRepository,
        private readonly CategoryMappingRepositoryInterface $categoryMappingRepository,
        private readonly CategoryMappingFactory $categoryMappingFactory,
        private readonly AttributeMappingRepositoryInterface $attributeMappingRepository,
        private readonly AttributeMappingFactory $attributeMappingFactory,
        private readonly RedirectFactory $redirectFactory,
        private readonly RedirectInterface $redirect,
        private readonly ManagerInterface $messageManager,
        private readonly LoggerInterface $logger
    ) {}

    public function execute(): Redirect
    {
        $postData = $this->request->getParams();
        $shop = $this->prepareShopData($postData);

        /** @var Redirect $redirect */
        $redirect = $this->redirectFactory->create();
        $redirect->setPath($this->redirect->getRefererUrl());

        try {
            $this->shopRepository->save($shop);
        } catch (NoSuchEntityException $noSuchEntityException) {
            $this->logger->error($noSuchEntityException->getMessage(), ['trace' => $noSuchEntityException->getTrace()]);
            $this->messageManager->addErrorMessage(__('Unable to save shop. Please check the input and try again.'));
            return $redirect;
        }

        /** @var Account $account */
        $account = $this->prepareAccountData($postData);

        if (isset($postData['id'])) {
            $account->setId((int) $postData['id']);
        }

        if ($shop->getId()) {
            $account->setShopId($shop->getId());
        }

        try {
            $this->accountRepository->save($account);
            if (!$account->getId()) {
                throw new NoSuchEntityException(__('Account ID could not be retrieved after save.'));
            }
        } catch (NoSuchEntityException $noSuchEntityException) {
            $this->logger->error($noSuchEntityException->getMessage(), ['trace' => $noSuchEntityException->getTrace()]);
            $this->messageManager->addErrorMessage(__('Unable to save account. Please verify your input and try again.'));
            return $redirect;
        }

        $categoryMappings = $postData['category_mapping']['dynamic_rows']['dynamic_rows'] ?? null;

        if (is_array($categoryMappings)) {
            $this->prepareMappingData($categoryMappings, $account);
            $categoryMappingData = array_map(fn($mapping) => $this->categoryMappingFactory->create(['data' => $mapping]), $categoryMappings);

            try {
                $this->categoryMappingRepository->saveMultiple($categoryMappingData);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage(), ['trace' => $e->getTrace()]);
                $this->messageManager->addErrorMessage(__('Could not save category mapping'));
            }
        }

        $attributeMappings = $postData['attribute_mapping']['dynamic_rows']['dynamic_rows'] ?? null;

        if (is_array($attributeMappings)) {
            $this->prepareMappingData($attributeMappings, $account);
            $attributeMappingData = array_map(fn($mapping) => $this->attributeMappingFactory->create(['data' => $mapping]), $attributeMappings);

            try {
                $this->attributeMappingRepository->saveMultiple($attributeMappingData);
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage(), ['trace' => $e->getTrace()]);
                $this->messageManager->addErrorMessage(__('Could not save attribute mapping'));
            }
        }

        $this->messageManager->addSuccessMessage(__('Account saved successfully.'));
        return $redirect->setPath('shopee_connector/account/edit/', ['id' => $account->getId()]);
    }

    private function prepareAccountData(array $postData): Account
    {
        /** @var Account $account */
        $account = $this->accountFactory->create();

        $accountData = array_merge(
            isset($postData['product']) && is_array($postData['product']) ? $postData['product'] : [],
            isset($postData['inventory']) && is_array($postData['inventory']) ? $postData['inventory'] : [],
            isset($postData['orders']) && is_array($postData['orders']) ? $postData['orders'] : []
        );

        $filteredData = array_filter($accountData, 'strlen');
        return $account->addData($filteredData);
    }

    private function prepareShopData(array $postData): Shop
    {
        /** @var Shop $shop **/
        $shop = $this->shopFactory->create();

        $shopData = isset($postData['general']) && is_array($postData['general']) ? $postData['general'] : [];
        $filteredData = array_filter($shopData, 'strlen');
        return $shop->addData($filteredData);
    }

    private function prepareMappingData(array &$mappings, Account $account): void
    {
        foreach ($mappings as &$mapping) {
            unset($mapping['initialize']);
            $mapping['account_id'] = $account->getId();
        }
    }
}
