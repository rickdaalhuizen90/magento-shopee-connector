<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api\Data;

interface ShopInterface
{
    public function getName(): string;

    public function isAuthenticated(): bool;
}
