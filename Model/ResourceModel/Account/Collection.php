<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\ResourceModel\Account;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Upvado\ShopeeConnector\Model\Account::class,
            \Upvado\ShopeeConnector\Model\ResourceModel\Account::class
        );
    }
}
