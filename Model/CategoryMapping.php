<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Model\AbstractModel;

class CategoryMapping extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Upvado\ShopeeConnector\Model\ResourceModel\CategoryMapping::class);
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

    public function getCategoryId(): int
    {
        return (int) $this->getData('category_id');
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->setData('category_id', $categoryId);
    }

    public function getSystemCategoryId(): int
    {
        return (int) $this->getData('system_category_id');
    }

    public function setSystemCategoryId(int $systemCategoryId): void
    {
        $this->setData('system_category_id', $systemCategoryId);
    }
}
