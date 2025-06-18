<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsInterfaceFactory;
use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Api\AttributeMappingRepositoryInterface;
use Upvado\ShopeeConnector\Model\ResourceModel\AttributeMapping as ResourceModel;
use Upvado\ShopeeConnector\Model\ResourceModel\AttributeMapping\CollectionFactory;

class AttributeMappingRepository implements AttributeMappingRepositoryInterface
{
    public function __construct(
        private readonly ResourceModel $resource,
        private readonly CollectionFactory $collectionFactory,
        private readonly SearchResultsInterfaceFactory $searchResultsFactory
    ) {}

    /**
     * @inheritdoc
     */
    public function saveMultiple(array $attributeMappings): bool
    {
        if ($attributeMappings === []) {
            return false;
        }

        try {
            $connection = $this->resource->getConnection();
            $connection->beginTransaction();
            $table = $this->resource->getMainTable();

            $accountIds[] = array_map(fn($mapping): int => $mapping->getAccountId(), $attributeMappings);
            if ($accountIds !== []) {
                $connection->delete($table, ['account_id in (?)' => $accountIds]);
            }

            foreach ($attributeMappings as $attributeMapping) {
                if (!$attributeMapping instanceof AttributeMapping) {
                    throw new LocalizedException(
                        __('Invalid attribute mapping object provided.')
                    );
                }

                $connection->insertOnDuplicate($table, $attributeMapping->getData());
            }

            $connection->commit();
        } catch (\Exception $exception) {
            $connection->rollBack();
            throw new LocalizedException(
                __('Unable to save attribute mappings: %1', $exception->getMessage())
            );
        }

        return true;
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
    public function removeMultiple(array $ids): int
    {
        return $this->resource->getConnection()->delete(
            $this->resource->getMainTable(),
            ['entity_id in (?)' => $ids]
        );
    }
}
