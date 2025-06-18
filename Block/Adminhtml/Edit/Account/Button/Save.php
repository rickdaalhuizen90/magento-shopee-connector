<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Block\Adminhtml\Edit\Account\Button;

use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Upvado\ShopeeConnector\Block\Adminhtml\Edit\Button\Generic;

class Save extends Generic implements ButtonProviderInterface
{
    /**
     * @return array<string, int|Phrase|string>
     */
    public function getButtonData(): array
    {
        $id = (int) $this->context->getRequest()->getParam('id');
        return [
            'label' => __('Save'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'shopee_connector_account_form.shopee_connector_account_form',
                                'actionName' => 'save',
                                'params' => [
                                    true,
                                    [
                                        'id' => $id,
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ],
            'sort_order' => 100,
        ];
    }
}
