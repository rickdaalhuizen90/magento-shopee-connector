<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Account\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Upvado\ShopeeConnector\Service\AttributeMappingService;

class AttributeMapping implements ModifierInterface
{
    public function __construct(
        readonly private AttributeMappingService $attributeMappingService
    ) {}

    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    public function modifyData(array $data): array
    {
        $mappings = $this->attributeMappingService->getMappingsByAccountId((int) $data['entity_id']);

        usort($mappings, fn($a, $b): int => $a->getRecordId() <=> $b->getRecordId());

        $result = [];

        foreach ($mappings as $mapping) {
            $result[] = [
                'record_id' => $mapping->getRecordId(),
                'attribute_id' => $mapping->getAttributeId(),
                'system_attribute_id' => $mapping->getSystemAttributeId(),
            ];
        }

        return [
            'attribute_mapping' => [
                'dynamic_rows' => [
                    'dynamic_rows' => $result,
                ],
            ],
        ];
    }
}
