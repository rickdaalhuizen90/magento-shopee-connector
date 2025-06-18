<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Product\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Attribute implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => '1', 'label' => __('Name')],
            ['value' => '2', 'label' => __('Description')],
            ['value' => '3', 'label' => __('Price')],
            ['value' => '4', 'label' => __('Category')],
            ['value' => '4', 'label' => __('Image')],
            ['value' => '5', 'label' => __('SKU')],
            ['value' => '7', 'label' => __('Product ID')],
            ['value' => '8', 'label' => __('Product URL')],
            ['value' => '9', 'label' => __('Quantity')],
        ];
    }
}
