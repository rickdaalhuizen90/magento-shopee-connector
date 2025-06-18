<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Controller\Adminhtml\Account;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Upvado\ShopeeConnector\Api\AccountRepositoryInterface;

class Delete extends Action implements HttpPostActionInterface
{
    public function __construct(
        Context $context,
        private readonly AccountRepositoryInterface $accountRepository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('id');

        try {
            $account = $this->accountRepository->get($id);
            $this->accountRepository->delete($account);
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            return $this->_redirect('*/*/index');
        }

        $this->messageManager->addSuccessMessage(__('Account has been deleted.'));
        return $this->_redirect('*/*/index');
    }
}
