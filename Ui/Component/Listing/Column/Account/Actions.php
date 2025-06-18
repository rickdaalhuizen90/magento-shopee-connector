<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\Component\Listing\Column\Account;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        protected \Magento\Framework\UrlInterface $urlBuilder,
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

                if (!array_key_exists('entity_id', $item)) {
                    continue;
                }

                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl(
                            'shopee_connector/account/edit',
                            ['id' => $item['entity_id']]
                        ),
                        'label' => __('Edit')
                    ],
                    'duplicate' => [
                        'href' => $this->urlBuilder->getUrl(
                            'shopee_connector/account/duplicate',
                            ['id' => $item['entity_id']]
                        ),
                        'label' => __('Duplicate')
                    ]
                ];

                if (array_key_exists('is_active', $item) && $item['is_active'] !== '0') {
                    $item[$this->getData('name')]['reauthorize'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'shopee_connector/account/reauthorize',
                            ['id' => $item['entity_id']]
                        ),
                        'label' => __('Reauthorize')
                    ];
                }
            }
        }

        return $dataSource;
    }
}
