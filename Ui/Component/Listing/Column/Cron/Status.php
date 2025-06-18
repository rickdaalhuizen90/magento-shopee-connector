<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\Component\Listing\Column\Cron;

use Magento\Cron\Model\Schedule;
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
                match ($item[$fieldName]) {
                    Schedule::STATUS_ERROR => 'grid-severity-critical',
                    Schedule::STATUS_MISSED => 'grid-severity-critical',
                    Schedule::STATUS_SUCCESS => 'grid-severity-notice',
                    default => 'grid-severity-default',
                },
                ucfirst((string) $item[$fieldName])
            );
        }

        return $dataSource;
    }
}
