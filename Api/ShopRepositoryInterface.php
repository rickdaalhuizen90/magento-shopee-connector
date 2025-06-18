<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api;

use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Model\Account;
use Upvado\ShopeeConnector\Model\Shop;

interface ShopRepositoryInterface
{
    /**
     * Save shop
     *
     * @param Shop $shop
     * @return ShopInterface
     * @throws LocalizedException
     */
    public function save(Shop $shop): Shop;

    /**
     * Retrieve shop by account
     *
     * @param Account $account
     * @return Shop
     * @throws LocalizedException
     */
    public function get(Account $account): Shop;

    /**
     * Retrieve shop by id
     *
     * @param int $id
     * @return Shop
     * @throws LocalizedException
     */
    public function getById(int $id): Shop;

    /**
     * Delete shop
     *
     * @return bool
     */
    public function delete(Shop $shop): bool;
}
