<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\Component\Listing\Column\Order;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Upvado\ShopeeConnector\Helper\DateTime;

class LastSyncedAt extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly DateTime $dateHelper,
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

        foreach ($dataSource['data']['items'] as &$item) {
            $lastSyncedAt = $item['last_synced_at'];
            $item[$fieldName] = sprintf(
                '<time datetime="%1$s" title="%1$s" style="cursor: default;">%2$s</time>',
                $lastSyncedAt,
                $this->dateHelper->getTimeAgo($lastSyncedAt)
            );
        }

        return $dataSource;
    }
}
