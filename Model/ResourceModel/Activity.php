<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Activity extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('upvado_shopee_activity', 'entity_id');
    }
}
