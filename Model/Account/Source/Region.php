<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Account\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Region implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => 'MY', 'label' => __('Malaysia')],
            ['value' => 'SG', 'label' => __('Singapore')],
            ['value' => 'ID', 'label' => __('Indonesia')]
        ];
    }
}
