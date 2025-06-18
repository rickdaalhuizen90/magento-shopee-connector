<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\Component\Listing\Column\Product;

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

                if (!ctype_digit((string) $item['entity_id'])) {
                    continue;
                }

                $item[$this->getData('name')] = [
                    'upload' => [
                        'href' => $this->urlBuilder->getUrl(
                            'shopee_connector/product/upload',
                            ['id' => $item['product_id']]
                        ),
                        'label' => __('Upload')
                    ],
                    'reauthorize' => [
                        'href' => $this->urlBuilder->getUrl(
                            'shopee_connector/product/delete',
                            ['id' => $item['product_id']]
                        ),
                        'label' => __('Delete')
                    ],
                ];
            }
        }

        return $dataSource;
    }
}
