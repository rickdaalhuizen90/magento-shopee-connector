<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Product\Listing;

use Magento\Framework\App\CacheInterface;
use Upvado\ShopeeConnector\Model\ResourceModel\Product\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param array<mixed> $meta
     * @param array<mixed> $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        private readonly CacheInterface $cache,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * @return array<string, array<int,mixed>|int>
     */
    public function getData(): array
    {
        $collection = $this->getCollection()->addFieldToSelect('*')
            ->join(
                ['account' => 'upvado_shopee_account'],
                'account.entity_id = main_table.account_id',
                ['shop_id' => 'shop_id']
            )
            ->join(
                ['shop' => 'upvado_shopee_shop'],
                'shop.shop_id = account.shop_id',
                ['shop_name' => 'name']
            )
            ->join(
                ['product_entity' => 'catalog_product_entity'],
                'product_entity.entity_id = main_table.product_id',
                ['sku']
            )
            ->join(
                ['inventory' => 'cataloginventory_stock_item'],
                'inventory.product_id = main_table.product_id',
                ['stock' => 'qty']
            )
            ->join(
                ['name' => 'catalog_product_entity_varchar'],
                'name.entity_id = main_table.product_id AND name.attribute_id = ' . $this->getCachedAttributeId('name'),
                ['product_name' => 'value']
            )
            ->join(
                ['price' => 'catalog_product_entity_decimal'],
                'price.entity_id = main_table.product_id AND price.attribute_id = ' . $this->getCachedAttributeId('price'),
                ['price' => 'value']
            );

        $collection->setOrder('main_table.last_synced_at', 'DESC');
        $collection->load();

        return $collection->toArray();
    }

    private function getCachedAttributeId(string $attributeCode): int
    {
        $cacheKey = 'attribute_id_' . $attributeCode;
        $attributeId = $this->cache->load($cacheKey);

        if ($attributeId === false) {
            $entityTypeTable = $this->collection->getResource()->getTable('eav_entity_type');
            $connection = $this->collection->getResource()->getConnection();

            $entityTypeId = $connection->fetchOne(
                $connection->select()
                    ->from($entityTypeTable, ['entity_type_id'])
                    ->where('entity_type_code = ?', 'catalog_product')
            );

            if (!$entityTypeId) {
                throw new \Exception('Unable to find the entity_type_id for catalog_product.');
            }

            $eavAttributeTable = $this->collection->getResource()->getTable('eav_attribute');
            $attributeId = (int)$connection->fetchOne(
                $connection->select()
                    ->from($eavAttributeTable, ['attribute_id'])
                    ->where('attribute_code = ?', $attributeCode)
                    ->where('entity_type_id = ?', $entityTypeId)
            );

            $this->cache->save((string)$attributeId, $cacheKey, [], 86400); // Cache for 1 day
        }

        return (int)$attributeId;
    }
}
