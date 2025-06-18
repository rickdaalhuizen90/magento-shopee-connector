<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\Component\Listing\Column\Product;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Details extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');
        $stockThreshold = 5;

        foreach ($dataSource['data']['items'] as &$item) {
            $stockLevel = (int)($item['stock'] ?? 0);

            $item[$fieldName] = sprintf(
                '<div class="custom-grid-cell">
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dotted #dfdfdf; padding: 3px 0;"><b>SKU:</b> %s</div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dotted #dfdfdf; padding: 3px 0;"><b>Price:</b> %s</div>
                    <div style="display: flex; justify-content: space-between; border-bottom: 1px dotted #dfdfdf; padding: 3px 0;"><b>Stock:</b> %d/%d</div>
                </div>',
                htmlspecialchars($item['sku'] ?? 'N/A'),
                number_format((float)($item['price'] ?? 0), 2),
                $stockLevel,
                $stockThreshold
            );
        }

        return $dataSource;
    }
}
