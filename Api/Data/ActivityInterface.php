<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api\Data;

interface ActivityInterface
{
    public function getActivity(): string;

    public function getEntityId(): ?int;
}
