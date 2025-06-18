<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\ResourceModel\AttributeMapping;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Upvado\ShopeeConnector\Model\AttributeMapping::class,
            \Upvado\ShopeeConnector\Model\ResourceModel\AttributeMapping::class
        );
    }
}
