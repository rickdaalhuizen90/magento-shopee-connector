<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Controller\Adminhtml\Account;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\NoSuchEntityException;
use Upvado\ShopeeConnector\Api\AccountRepositoryInterface;
use Upvado\ShopeeConnector\Api\AttributeMappingRepositoryInterface;
use Upvado\ShopeeConnector\Api\CategoryMappingRepositoryInterface;
use Upvado\ShopeeConnector\Model\AccountFactory;
use Upvado\ShopeeConnector\Model\AttributeMappingFactory;
use Upvado\ShopeeConnector\Model\CategoryMappingFactory;

class Duplicate extends Action implements HttpGetActionInterface
{
    public function __construct(
        private readonly Http $request,
        private readonly AccountRepositoryInterface $accountRepository,
        private readonly AccountFactory $accountFactory,
        private readonly ResourceConnection $resource,
        private readonly CategoryMappingRepositoryInterface $categoryMappingRepository,
        private readonly CategoryMappingFactory $categoryMappingFactory,
        private readonly AttributeMappingRepositoryInterface $attributeMappingRepository,
        private readonly AttributeMappingFactory $attributeMappingFactory,
        Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $accountId = (int) $this->request->getParam('id');
        $connection = $this->resource->getConnection();

        try {
            $account = $this->accountRepository->get($accountId);

            $newAccount = $this->accountFactory->create();
            $account->unsetData(['entity_id', 'shop_id', 'created_at', 'updated_at']);
            $account->setIsActive(0);

            $newAccount->addData($account->getData());

            /** @var \Upvado\ShopeeConnector\Model\Account $createdAccount */
            $newAccount = $this->accountRepository->save($newAccount);

            $duplicatedCategoryMappings = $connection->fetchAssoc(
                'SELECT record_id, system_category_id, category_id FROM upvado_shopee_category_mapping WHERE account_id = :account_id',
                ['account_id' => $accountId]
            );

            $categoryMappings = [];

            foreach ($duplicatedCategoryMappings as $duplicateCategoryMapping) {
                $categoryMapping = $this->categoryMappingFactory->create();
                $categoryMapping->addData($duplicateCategoryMapping);
                $categoryMapping->setAccountId((int) $newAccount->getId());
                $categoryMappings[] = $categoryMapping;
            }

            $duplicateAttributeMappings = $connection->fetchAssoc(
                'SELECT record_id, system_attribute_id, attribute_id FROM upvado_shopee_attribute_mapping WHERE account_id = :account_id',
                ['account_id' => $accountId]
            );

            $attributeMappings = [];

            foreach ($duplicateAttributeMappings as $duplicateAttributeMapping) {
                $attributeMapping = $this->attributeMappingFactory->create();
                $attributeMapping->addData($duplicateAttributeMapping);
                $attributeMapping->setAccountId((int) $newAccount->getId());
                $attributeMappings[] = $attributeMapping;
            }

            $this->categoryMappingRepository->saveMultiple($categoryMappings);
            $this->attributeMappingRepository->saveMultiple($attributeMappings);
        } catch (NoSuchEntityException $noSuchEntityException) {
            $this->messageManager->addErrorMessage(__('Account not found: %1', $noSuchEntityException->getMessage()));
            return $this->_redirect('*/*');
        }

        $this->messageManager->addSuccessMessage(
            __('Successfully duplicated account')
        );

        $this->_redirect('shopee_connector/account/edit', ['id' => $newAccount->getId()]);
        return null;
    }
}
