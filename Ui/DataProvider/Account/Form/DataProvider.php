<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Account\Form;

use Upvado\ShopeeConnector\Model\ResourceModel\Account\CollectionFactory;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        private readonly PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $items = $this->collection->getItems();

        foreach ($items as $item) {
            $data = $item->getData();
            $this->data[$item->getId()]['id'] = $item->getId();
            foreach ($this->pool->getModifiersInstances() as $modifier) {
                if (isset($this->data[$item->getId()])) {
                    $this->data[$item->getId()] = array_merge($this->data[$item->getId()], $modifier->modifyData($data));
                } else {
                    $this->data[$item->getId()] = $modifier->modifyData($data);
                }
            }
        }

        return $this->data;
    }

    public function getMeta()
    {
        $meta = parent::getMeta();

        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }
}
