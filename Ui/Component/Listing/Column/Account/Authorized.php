<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\Component\Listing\Column\Account;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Upvado\ShopeeConnector\Helper\DateTime;

class Authorized extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected \Magento\Framework\UrlInterface $urlBuilder,
        private readonly DateTime $dateHelper,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (!is_array($item)) {
                    continue;
                }

                // if token exist and is not expired by account_id
                $authorized = $item['updated_at'] ?: $item['created_at'];
                $item[$this->getData('name')] = $this->dateHelper->getTimeAgo($authorized);
            }
        }

        return $dataSource;
    }
}
