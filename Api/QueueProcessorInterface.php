<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api;

interface QueueProcessorInterface
{
    public function process(): void;
}