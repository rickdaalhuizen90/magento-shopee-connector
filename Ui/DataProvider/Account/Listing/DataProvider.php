<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Account\Listing;

use Upvado\ShopeeConnector\Model\ResourceModel\Account\CollectionFactory;

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
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create(); // @phpstan-ignore assign.propertyType
    }

    /**
     * @return array<string, array<int,mixed>|int>
     */
    public function getData(): array
    {
        $this->getCollection()->getSelect()
            ->joinLeft(
                'upvado_shopee_token',
                'main_table.entity_id = upvado_shopee_token.account_id',
                ['expire_in', 'created_at', 'updated_at']
            )->joinLeft(
                'upvado_shopee_shop',
                'main_table.shop_id = upvado_shopee_shop.shop_id',
                ['name', 'region']
            );

        return $this->getCollection()->toArray();
    }
}
