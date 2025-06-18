<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Model\CategoryMapping;

interface CategoryMappingRepositoryInterface
{
    /**
     * Save category mappings
     *
     * @param CategoryMapping[] $categoryMappings
     * @return bool
     * @throws LocalizedException
     */
    public function saveMultiple(array $categoryMappings): bool;

    /**
     * Get category mapping list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete category mappings
     *
     * @return bool
     */
    public function removeMultiple(array $ids): int;
}
