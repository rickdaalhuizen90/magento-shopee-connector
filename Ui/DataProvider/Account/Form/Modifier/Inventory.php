<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Account\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class Inventory implements ModifierInterface
{
    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    public function modifyData(array $data): array
    {
        return [
            'inventory' => [
                'sync_inventory' => $data['sync_inventory'] ?: 1,
                'inventory_threshold' => $data['inventory_threshold'] ?: null,
            ],
        ];
    }
}
