<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Model\AbstractModel;
use Upvado\ShopeeConnector\Api\Data\ActivityInterface;

class Activity extends AbstractModel implements ActivityInterface
{
    protected function _construct()
    {
        $this->_init(\Upvado\ShopeeConnector\Model\ResourceModel\Activity::class);
    }

    public function getEntityId(): ?int
    {
        if ($this->getData('entity_id')) {
            return (int) $this->getData('entity_id');
        }

        return null;
    }

    public function getActivity(): string
    {
        return $this->getData('activity');
    }
}
