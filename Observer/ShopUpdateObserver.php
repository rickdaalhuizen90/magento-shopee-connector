<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Observer;

use Magento\Framework\Event\ObserverInterface;
use Upvado\ShopeeConnector\Model\AccountFactory;

class ShopUpdateObserver implements ObserverInterface
{
    public function __construct(private readonly AccountFactory $accountFactory)
    {
    }

    public function execute(\Magento\Framework\Event\Observer $observer): void
    {
        $shopId = $observer->getData('shop_id');
        $account = $this->accountFactory->create();

        // Send get_shop_info request
        // Save shop information to account
        dd($shopId);
    }
}
