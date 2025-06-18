<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Category implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => '', 'label' => __('-- Please Select --')],
            ['value' => '1', 'label' => __('Men')],
            ['value' => '2', 'label' => __('Women')],
            ['value' => '3', 'label' => __('Promotion')],
            ['value' => '4', 'label' => __('Other')],
        ];
    }
}
