<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Service\Mapping;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Upvado\ShopeeConnector\Api\CategoryMappingRepositoryInterface;

class CategoryService
{
    public function __construct(
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly FilterBuilder $filterBuilder,
        private readonly FilterGroupBuilder $filterGroupBuilder,
        private readonly CategoryMappingRepositoryInterface $categoryMappingRepository
    ) {}

    /**
     * Get category mappings by account_id.
     *
     * @param int $accountId
     * @return \Upvado\ShopeeConnector\Api\Data\CategoryMappingInterface[]
     */
    public function getMappingsByAccountId(int $accountId): array
    {
        $accountIdFilter = $this->filterBuilder
            ->setField('account_id')
            ->setValue($accountId)
            ->setConditionType('eq')
            ->create();

        $filterGroup = $this->filterGroupBuilder
            ->addFilter($accountIdFilter)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups([$filterGroup])
            ->create();

        $searchResults = $this->categoryMappingRepository->getList($searchCriteria);
        return $searchResults->getItems();
    }
}
