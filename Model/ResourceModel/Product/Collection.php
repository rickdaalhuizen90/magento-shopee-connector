<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\ResourceModel\Product;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Upvado\ShopeeConnector\Model\Product::class,
            \Upvado\ShopeeConnector\Model\ResourceModel\Product::class
        );
    }
}
