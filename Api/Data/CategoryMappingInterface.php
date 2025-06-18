<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api\Data;

interface CategoryMappingInterface
{
    public function getRecordId(): int;

    public function setRecordId(int $recordId): void;

    public function getAccountId(): int;

    public function setAccountId(int $accountId): void;

    public function getCategoryId(): int;

    public function setCategoryId(int $categoryId): void;

    public function getSystemCategoryId(): int;

    public function setSystemCategoryId(int $systemCategoryId): void;
}
