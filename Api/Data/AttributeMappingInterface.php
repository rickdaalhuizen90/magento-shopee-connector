<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api\Data;

interface AttributeMappingInterface
{
    public function getRecordId(): int;

    public function setRecordId(int $recordId): void;

    public function getAccountId(): int;

    public function setAccountId(int $accountId): void;

    public function getAttributeId(): int;

    public function getSystemAttributeId(): int;

    public function setAttributeId(int $attributeId): void;

    public function setSystemAttributeId(int $systemAttributeId): void;
}
