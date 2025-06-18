<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Helper;

use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class DateTime
{
    public function __construct(private readonly TimezoneInterface $timezone) {}

    public function getTimeAgo($timestamp): Phrase
    {
        $datetime = $this->timezone->date($timestamp);
        $now = $this->timezone->date();
        $interval = $datetime->diff($now);
        if ($interval->y > 0) {
            return __('%1 year%2 ago', $interval->y, $interval->y > 1 ? 's' : '');
        }

        if ($interval->m > 0) {
            return __('%1 month%2 ago', $interval->m, $interval->m > 1 ? 's' : '');
        }

        if ($interval->d > 6) {
            return __('%1', $datetime->format('M d, Y, H:i A'));
        }

        if ($interval->d > 0) {
            return __('%1 day%2 ago', $interval->d, $interval->d > 1 ? 's' : '');
        }

        if ($interval->h > 0) {
            return __('%1 hour%2 ago', $interval->h, $interval->h > 1 ? 's' : '');
        }

        if ($interval->i > 0) {
            return __('%1 minute%2 ago', $interval->i, $interval->i > 1 ? 's' : '');
        }

        if ($interval->s > 0) {
            return __('%1 second%2 ago', $interval->s, $interval->s > 1 ? 's' : '');
        }

        return __('Just now');
    }
}
