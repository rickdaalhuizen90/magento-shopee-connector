<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Model\AttributeMapping;

interface AttributeMappingRepositoryInterface
{
    /**
     * Save attribute mappings
     *
     * @param AttributeMapping[] $attributeMappings
     * @return bool
     * @throws LocalizedException
     */
    public function saveMultiple(array $attributeMappings): bool;

    /**
     * Get attribute mapping list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete attribute mappings
     *
     * @return bool
     */
    public function removeMultiple(array $ids): int;
}
