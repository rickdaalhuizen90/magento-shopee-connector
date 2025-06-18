<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Account\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class Product implements ModifierInterface
{
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    public function modifyData(array $data): array
    {
        return [
            'product' => [
                'product_upload' => $data['product_upload'] ?: 1,
                'price_adjustment_type' => $data['price_adjustment_type'] ?: null,
                'price_adjustment_value' => $data['price_adjustment_value'] ?: null,
                'fulfillment_time' => $data['fulfillment_time'] ?: null,
            ],
        ];
    }
}
