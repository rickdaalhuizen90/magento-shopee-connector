<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Shipping\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Carrier implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => 'todo', 'label' => __('Todo')],
        ];
    }
}
