<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Cron\Source;

use Magento\Cron\Model\ResourceModel\Schedule\CollectionFactory;
use Magento\Cron\Model\ResourceModel\Schedule\Collection;
use Magento\Framework\Data\OptionSourceInterface;

class Job implements OptionSourceInterface
{
    private array $options = [];

    public function __construct(
        private readonly CollectionFactory $collectionFactory
    ) {}

    public function toOptionArray(): array
    {
        if ($this->options !== []) {
            return $this->options;
        }

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToSelect('job_code')
            ->addFieldToFilter('job_code', ['like' => 'shopee_%'])
            ->getSelect()->group('job_code');

        foreach ($collection->getItems() as $item) {
            $this->options[] = ['value' => $item->getJobCode(), 'label' => $item->getJobCode(),];
        }

        return $this->options;
    }
}
