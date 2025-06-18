<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Account\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class Orders implements ModifierInterface
{
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    public function modifyData(array $data): array
    {
        return [
            'orders' => [
                'fetch_orders' => $data['fetch_orders'] ?: 1,
                'default_shipping_method' => $data['default_shipping_method'] ?: null,
                'default_payment_method' => $data['default_payment_method'] ?: null,
            ],
        ];
    }
}
