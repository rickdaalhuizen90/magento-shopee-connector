<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Block\Adminhtml\Account;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Upvado\ShopeeConnector\Api\AccountRepositoryInterface;
use Upvado\ShopeeConnector\Model\Account;

class Status extends Template
{
    public function __construct(
        private readonly AccountRepositoryInterface $accountRepository,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getAccount(): ?Account
    {
        $id = (int) $this->getRequest()->getParam('id');

        try {
            return $this->accountRepository->get($id);
        } catch (NoSuchEntityException) {
            return null;
        }
    }

    public function getAlertMessage(): Phrase
    {
        return __('Your Shopee account is not connected. To get started please connect your account by clicking the <b>"Authorize"</b> button or this <a href="%1" target="blank">link</a>.', 'https://example.com');
    }
}
