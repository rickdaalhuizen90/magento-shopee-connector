<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\Component\Listing\Column\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Thumbnail extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly Image $imageHelper,
        private readonly UrlInterface $urlBuilder,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder,
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
        $productIds = array_column($dataSource['data']['items'], 'product_id');
        $productData = $this->getProductData($productIds);

        foreach ($dataSource['data']['items'] as &$item) {
            $productId = $item['product_id'];
            if (isset($productData[$productId])) {
                $productInfo = $productData[$productId];

                $item[$fieldName . '_src'] = $productInfo['thumbnail_url'];
                $item[$fieldName . '_alt'] = in_array($this->getAlt($item), ['', '0'], true) ? $productInfo['alt'] : $this->getAlt($item);
                $item[$fieldName . '_link'] = $productInfo['edit_link'];
                $item[$fieldName . '_orig_src'] = $productInfo['orig_thumbnail_url'];
            }
        }

        return $dataSource;
    }

    private function getProductData(array $productIds): array
    {
        if ($productIds === []) {
            return [];
        }

        $productData = [];
        $storeId = $this->context->getRequestParam('store') ?? 0;

        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('entity_id', $productIds, 'in')
            ->addFilter('store_id', $storeId, 'eq')
            ->create();

        $products = $this->productRepository->getList($searchCriteria)->getItems();

        foreach ($products as $product) {
            $productId = $product->getId();
            $thumbnailUrl = $this->imageHelper->init($product, 'product_listing_thumbnail')->getUrl();
            $origThumbnailUrl = $this->imageHelper->init($product, 'product_listing_thumbnail_preview')->getUrl();
            $editLink = $this->urlBuilder->getUrl('catalog/product/edit', [
                'id' => $productId,
                'store' => $storeId,
            ]);

            $productData[$productId] = [
                'thumbnail_url' => $thumbnailUrl,
                'orig_thumbnail_url' => $origThumbnailUrl,
                'alt' => $product->getName(),
                'edit_link' => $editLink,
            ];
        }

        return $productData;
    }

    private function getAlt(array $row): string
    {
        return (string) ($row[$this->getData('config/altField')] ?? '');
    }
}
