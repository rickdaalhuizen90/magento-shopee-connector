<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Activity\Listing;

use Upvado\ShopeeConnector\Model\ResourceModel\Activity\CollectionFactory;

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
        $collection = $this->getCollection()->addFieldToSelect(['message', 'activity', 'response', 'trace', 'status_code', 'occurred_at',]);
        $collection->join(
            ['account' => 'upvado_shopee_account'],
            'account.entity_id = main_table.account_id',
            ['shop_id' => 'shop_id']
        )->join(
            ['shop' => 'upvado_shopee_shop'],
            'shop.shop_id = account.shop_id',
            ['shop_name' => 'name']
        );

        return $collection->toArray();
    }
}
