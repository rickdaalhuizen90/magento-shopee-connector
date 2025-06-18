<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Order\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => 'todo', 'label' => __('Todo')],
        ];
    }
}
