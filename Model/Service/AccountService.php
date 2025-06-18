<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Upvado\ShopeeConnector\Api\AccountRepositoryInterface;

class AccountService
{
    public function __construct(
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
        private readonly FilterBuilder $filterBuilder,
        private readonly FilterGroupBuilder $filterGroupBuilder,
        private readonly AccountRepositoryInterface $accountRepository
    ) {}

    /**
     * Get active accounts.
     *
     * @param int $accountId
     * @return \Upvado\ShopeeConnector\Model\Account[]
     */
    public function getActiveAccounts(): array
    {
        $accountIdFilter = $this->filterBuilder
            ->setField('is_active')
            ->setValue(true)
            ->setConditionType('eq')
            ->create();

        $filterGroup = $this->filterGroupBuilder
            ->addFilter($accountIdFilter)
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups([$filterGroup])
            ->create();

        $searchResults = $this->accountRepository->getList($searchCriteria);
        return $searchResults->getItems();
    }
}
