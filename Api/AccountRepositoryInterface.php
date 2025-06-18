<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Model\Account;

interface AccountRepositoryInterface
{
    /**
     * Save account
     *
     * @param Account $account
     * @return AccountInterface
     * @throws LocalizedException
     */
    public function save(Account $account): Account;

    /**
     * Retrieve account
     *
     * @param int $id
     * @return Account
     * @throws LocalizedException
     */
    public function get(int $id): Account;

    /**
     * Get account list
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete account
     *
     * @return bool
     */
    public function delete(Account $account): bool;
}
