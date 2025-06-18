<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Cron\Listing;

use Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory;

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
        $collection = $this->getCollection()->addFieldToSelect([
            'job_code',
            'status',
            'messages',
            'scheduled_at',
            'executed_at',
            'finished_at',
        ])
            ->addFieldToFilter('job_code', ['like' => 'shopee_%'])
            ->setOrder('scheduled_at');

        return $collection->toArray();
    }
}
