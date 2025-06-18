<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Model\AbstractModel;
use Upvado\ShopeeConnector\Api\Data\AttributeMappingInterface;

class AttributeMapping extends AbstractModel implements AttributeMappingInterface
{
    protected function _construct()
    {
        $this->_init(\Upvado\ShopeeConnector\Model\ResourceModel\AttributeMapping::class);
    }

    public function getRecordId(): int
    {
        return (int) $this->getData('record_id');
    }

    public function setRecordId(int $recordId): void
    {
        $this->setData('record_id', $recordId);
    }

    public function getAccountId(): int
    {
        return (int) $this->getData('account_id');
    }

    public function setAccountId(int $accountId): void
    {
        $this->setData('account_id', $accountId);
    }

    public function getAttributeId(): int
    {
        return (int) $this->getData('attribute_id');
    }

    public function getSystemAttributeId(): int
    {
        return (int) $this->getData('system_attribute_id');
    }

    public function setAttributeId(int $attributeId): void
    {
        $this->setData('attribute_id', $attributeId);
    }

    public function setSystemAttributeId(int $systemAttributeId): void
    {
        $this->setData('system_attribute_id', $systemAttributeId);
    }
}
