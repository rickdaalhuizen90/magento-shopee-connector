<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Block\Adminhtml\Edit\Account\Button;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Upvado\ShopeeConnector\Block\Adminhtml\Edit\Button\Generic;

class Duplicate extends Generic implements ButtonProviderInterface
{
    /**
     * @return array<string, int|Phrase|string>
     */
    public function getButtonData(): array
    {
        $id = (int) $this->context->getRequest()->getParam('id');
        return [
            'label' => __('Duplicate'),
            'class' => 'duplicate',
            'url' => $this->getUrl('shopee_connector/account/duplicate', ['id' => $id]),
            'sort_order' => 80,
        ];
    }
}
