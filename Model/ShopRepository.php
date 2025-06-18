<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Upvado\ShopeeConnector\Api\ShopRepositoryInterface;
use Upvado\ShopeeConnector\Api\Data\ShopInterface;
use Upvado\ShopeeConnector\Model\ShopFactory;
use Upvado\ShopeeConnector\Model\Shop;
use Upvado\ShopeeConnector\Model\ResourceModel\Shop as ResourceModel;

class ShopRepository implements ShopRepositoryInterface
{
    public function __construct(private readonly ShopFactory $shopFactory, private readonly ResourceModel $resource) {}

    /**
     * @inheritdoc
     */
    public function save(Shop $shop): Shop
    {
        try {
            $this->resource->save($shop);
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to save shop: %1', $exception->getMessage()));
        }

        return $shop;
    }

    /**
     * @inheritdoc
     */
    public function get(Account $account): Shop
    {
        $model = $this->shopFactory->create();

        $this->resource->load($model, $account->getShopId(), 'shop_id');
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('Unable to retrieve shop by access shop for account: %1', $account->getId()));
        }

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function getById(int $id): Shop
    {
        $model = $this->shopFactory->create();

        $this->resource->load($model, $id, 'shop_id');
        if (!$model->getId()) {
            throw new NoSuchEntityException(__('Unable to retrieve shop by access shop: %1', $id));
        }

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function delete(Shop $shop): bool
    {
        try {
            $this->resource->delete($shop);
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to delete shop: %1', $exception->getMessage()));
        }

        return true;
    }
}
