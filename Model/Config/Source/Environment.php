<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Environment implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => 1, 'label' => __('Production')],
            ['value' => 0, 'label' => __('Sandbox')]
        ];
    }
}
