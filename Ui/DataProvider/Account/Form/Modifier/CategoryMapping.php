<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Account\Form\Modifier;

use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Upvado\ShopeeConnector\Service\CategoryMappingService;

class CategoryMapping implements ModifierInterface
{
    public function __construct(
        readonly private CategoryMappingService $categoryMappingService
    ) {}

    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    public function modifyData(array $data): array
    {
        $mappings = $this->categoryMappingService->getMappingsByAccountId((int) $data['entity_id']);

        usort($mappings, fn($a, $b): int => $a->getRecordId() <=> $b->getRecordId());

        $result = [];

        foreach ($mappings as $mapping) {
            $result[] = [
                'record_id' => $mapping->getRecordId(),
                'category_id' => $mapping->getCategoryId(),
                'system_category_id' => $mapping->getSystemCategoryId(),
            ];
        }

        return [
            'category_mapping' => [
                'dynamic_rows' => [
                    'dynamic_rows' => $result,
                ],
            ],
        ];
    }
}
