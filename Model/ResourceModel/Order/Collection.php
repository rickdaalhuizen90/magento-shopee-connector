<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\ResourceModel\Order;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Upvado\ShopeeConnector\Model\Order::class,
            \Upvado\ShopeeConnector\Model\ResourceModel\Order::class
        );
    }
}
