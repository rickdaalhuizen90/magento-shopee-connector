<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Api\AccountRepositoryInterface;
use Upvado\ShopeeConnector\Model\AccountFactory;
use Upvado\ShopeeConnector\Model\Account;
use Upvado\ShopeeConnector\Model\ResourceModel\Account as ResourceModel;
use Upvado\ShopeeConnector\Model\ResourceModel\Account\CollectionFactory;

class AccountRepository implements AccountRepositoryInterface
{
    public function __construct(
        private readonly AccountFactory $accountFactory,
        private readonly CollectionFactory $collectionFactory,
        private readonly SearchResultsInterfaceFactory $searchResultsFactory,
        private readonly ResourceModel $resource
    ) {}

    /**
     * @inheritdoc
     */
    public function save(Account $account): Account
    {
        try {
            $this->resource->save($account);
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to save account: %1', $exception->getMessage()));
        }

        return $account;
    }

    /**
     * @inheritdoc
     */
    public function get(int $id): Account
    {
        $model = $this->accountFactory->create();

        try {
            $this->resource->load($model, $id, 'entity_id');
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to retrieve account by access account: %1', $exception->getMessage()));
        }

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $field = $filter->getField();
                $value = $filter->getValue();
                $conditionType = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($field, [$conditionType => $value]);
            }
        }

        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $collection->setOrder($sortOrder->getField(), $sortOrder->getDirection());
        }

        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setSearchCriteria($searchCriteria);

        return $searchResults;
    }



    /**
     * @inheritdoc
     */
    public function delete(Account $account): bool
    {
        try {
            $this->resource->delete($account);
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to delete account: %1', $exception->getMessage()));
        }

        return true;
    }
}
