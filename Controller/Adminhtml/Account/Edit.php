<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Controller\Adminhtml\Account;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;
use Upvado\ShopeeConnector\Api\AccountRepositoryInterface;

class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    public function __construct(
        Context $context,
        private readonly PageFactory $resultPageFactory,
        private readonly AccountRepositoryInterface $accountRepository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');

        try {
            $account = $this->accountRepository->get($id);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            return $this->_redirect('*/*/index');
        }

        //Account is about to expire. Token will be renewed in 2020-01-01 00:00:00
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Account ID: %1', $account->getEntityId()));
        return $resultPage;
    }
}
