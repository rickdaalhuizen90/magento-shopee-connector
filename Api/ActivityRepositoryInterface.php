<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api;

use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Api\Data\ActivityInterface;

interface ActivityRepositoryInterface
{
    /**
     * Save activity
     *
     * @param ActivityInterface $activity
     * @return ActivityInterface
     * @throws LocalizedException
     */
    public function save(ActivityInterface $activity): ActivityInterface;

    /**
     * Retrieve activity
     *
     * @param int $id
     * @return ActivityInterface
     * @throws LocalizedException
     */
    public function get(int $id): ActivityInterface;

    /**
     * Delete activity
     *
     * @return bool
     */
    public function delete(ActivityInterface $activity): bool;
}
