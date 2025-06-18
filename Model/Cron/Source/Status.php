<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Cron\Source;

use Magento\Cron\Model\Schedule;
use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            [
                'value' => Schedule::STATUS_ERROR,
                'label' => Schedule::STATUS_ERROR,
            ],
            [
                'value' => Schedule::STATUS_SUCCESS,
                'label' => Schedule::STATUS_SUCCESS,
            ],
            [
                'value' => Schedule::STATUS_MISSED,
                'label' => Schedule::STATUS_MISSED,
            ],
            [
                'value' => Schedule::STATUS_PENDING,
                'label' => Schedule::STATUS_PENDING,
            ],
            [
                'value' => Schedule::STATUS_RUNNING,
                'label' => Schedule::STATUS_RUNNING,
            ],
        ];
    }
}
