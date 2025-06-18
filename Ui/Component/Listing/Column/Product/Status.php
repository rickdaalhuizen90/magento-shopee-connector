<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\Component\Listing\Column\Product;

use Magento\Ui\Component\Listing\Columns\Column;

class Status extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');

        foreach ($dataSource['data']['items'] as &$item) {
            $item[$fieldName] = sprintf(
                '<span class="%s">%s</span>',
                match ((int) $item[$fieldName]) {
                    0 => 'grid-severity-critical',
                    1 => 'grid-severity-notice',
                    default => 'grid-severity-default',
                },
                match ((int) $item[$fieldName]) {
                    0 => __('Critical'),
                    1 => __('Success'),
                    default => __('Pending')
                }
            );
        }

        return $dataSource;
    }
}
