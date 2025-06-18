<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Order\Listing;

use Upvado\ShopeeConnector\Model\ResourceModel\Order\CollectionFactory;

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
        $collection = $this->getCollection()->addFieldToSelect('*');
        $collection->load();

        return [
            'totalRecords' => 1,
            'items' => [
                [
                    'entity_id' => 1,
                    'order_sn' => '2404098R48U37H',
                    'magento_order_id' => '000000004',
                    'region' => 'SG',
                    'customer_firstname' => 'Tom',
                    'customer_lastname' => 'Smith',
                    'total_amount' => 1000.0000,
                    'status' => 'PROCESSING',
                    'last_synced_at' => '2022-01-01 00:00:00',
                ],
            ],
        ];
    }
}
