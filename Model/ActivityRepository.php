<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Api\Data\ActivityInterface;
use Upvado\ShopeeConnector\Api\ActivityRepositoryInterface;
use Upvado\ShopeeConnector\Model\ResourceModel\Activity as ResourceModel;
use Upvado\ShopeeConnector\Model\ActivityFactory;

class ActivityRepository implements ActivityRepositoryInterface
{
    public function __construct(private readonly ActivityFactory $activityFactory, private readonly ResourceModel $resource)
    {
    }

    /**
     * @inheritdoc
     */
    public function save(ActivityInterface $activity): ActivityInterface
    {
        try {
            $this->resource->save($activity);
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to save activity: %1', $exception->getMessage()));
        }

        return $activity;
    }

    /**
     * @inheritdoc
     */
    public function get(int $id): ActivityInterface
    {
        $activity = $this->activityFactory->create();

        try {
            $this->resource->load($activity, $id, 'entity_id');
            if (!$activity->getEntityId()) {
                throw new LocalizedException(__('No activity found for the provided id.'));
            }
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to retrieve activity by access activity: %1', $exception->getMessage()));
        }

        return $activity;
    }

    /**
     * @inheritdoc
     */
    public function delete(ActivityInterface $activity): bool
    {
        try {
            $this->resource->delete($activity);
        } catch (\Exception $exception) {
            throw new LocalizedException(__('Unable to delete activity: %1', $exception->getMessage()));
        }

        return true;
    }
}
