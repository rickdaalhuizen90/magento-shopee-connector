<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Cron;

use Exception;
use Psr\Log\LoggerInterface;
use Upvado\ShopeeConnector\Model\ResourceModel\Account\CollectionFactory as AccountCollectionFactory;
use Upvado\ShopeeConnector\Model\ResourceModel\Shop\CollectionFactory as ShopCollectionFactory;
use Upvado\ShopeeConnector\Model\Adapter\ShopeeAdapter;

class FetchOrders
{
    public function __construct(
        private readonly AccountCollectionFactory $accountCollectionFactory,
        private readonly ShopCollectionFactory $shopCollectionFactory,
        private readonly ShopeeAdapter $shopeeAdapter,
        private readonly LoggerInterface $logger
    ) {}

    public function execute(): void
    {
        $shopCollection = $this->getShopCollection();
        
        foreach ($shopCollection->getItems() as $shop) {
            $orders = $this->shopeeAdapter->getOrdersByShop($shop);
            print_r($orders);
        }
    }

    private function getAccountIds(): array
    {
        $accountCollection = $this->accountCollectionFactory->create();
        $accountCollection->addFieldToFilter('is_active', 1);

        if ($accountCollection->getSize() === 0) {
            throw new Exception('ShopeeConnector: No account IDs found to process for FetchOrders.');
        }

        return $accountCollection->getAllIds();
    }

    private function getShopCollection()
    {
        $shopCollection = $this->shopCollectionFactory->create();
        $shopCollection->addFieldToFilter('account_id', ['in' => $this->getAccountIds()]);
        $shopCollection->addFieldToFilter('is_active', 1);

        if ($shopCollection->getSize() === 0) {
            throw new Exception('ShopeeConnector: No shops found for the active account IDs.');
        }

        return $shopCollection;
    }
}
