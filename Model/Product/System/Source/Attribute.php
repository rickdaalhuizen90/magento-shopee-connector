<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Product\System\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Attribute implements OptionSourceInterface
{
    public function __construct(private readonly \Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection $collection)
    {
    }

    public function toOptionArray(): array
    {
        $collection = $this->collection->addFieldToFilter('is_visible_on_front', 1);

        $options = [];
        foreach ($collection->getItems() as $item) {
            $options[] = [
                'value' => $item->getAttributeId(),
                'label' => $item->getFrontendLabel(),
            ];
        }

        return $options;
    }
}
