<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Model\AbstractModel;

class Account extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Upvado\ShopeeConnector\Model\ResourceModel\Account::class);
    }

    public function isActive(): bool
    {
        return (bool) $this->getData('is_active');
    }
}
