<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Block\Adminhtml\Edit\Account\Button;

use Magento\Backend\Block\Widget\Button\SplitButton;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Upvado\ShopeeConnector\Api\AccountRepositoryInterface;
use Upvado\ShopeeConnector\Block\Adminhtml\Edit\Button\Generic;

class Authorize extends Generic implements ButtonProviderInterface
{
    public function __construct(
        Context $context,
        private readonly AccountRepositoryInterface $accountRepository
    ) {
        parent::__construct($context);
    }

    /**
     * @return array<string, int|Phrase|string|array>
     */
    public function getButtonData(): array
    {
        $data = [
            'label' => __('Authorize'),
            'class' => 'secondary',
            'options' => [
                [
                    'label' => __('Singapore'),
                    'onclick' => 'alert("Redirect to Singapore server")',
                    'default' => true,
                ],
                [
                    'label' => __('Mainland China'),
                    'onclick' => 'alert("Redirect to China server")',
                ],
                [
                    'label' => __('Brazil'),
                    'onclick' => 'alert("Redirect to Brazil server")',
                ],
            ],
            'class_name' => SplitButton::class,
            'sort_order' => 90,
        ];

        $fieldId = (int) $this->context->getRequest()->getParam('id');

        try {
            $account = $this->accountRepository->get($fieldId);
        } catch (NoSuchEntityException) {
            return [];
        }

        if ($account->isActive()) {
            $data['label'] = __('Reauthorize');
            $data['url'] = $this->getUrl('shopee_connector/oauth/refresh', ['id' => $fieldId]);
            unset($data['class_name']);
            unset($data['options']);
        }

        return $data;
    }
}
