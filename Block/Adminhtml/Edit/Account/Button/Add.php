<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Block\Adminhtml\Edit\Account\Button;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Upvado\ShopeeConnector\Block\Adminhtml\Edit\Button\Generic;

class Add extends Generic implements ButtonProviderInterface
{
    /**
     * @return array<string, int|Phrase|string>
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Add Account'),
            'class' => 'add primary',
            'url' => $this->getUrl('shopee_connector/account/new'),
        ];
    }
}
