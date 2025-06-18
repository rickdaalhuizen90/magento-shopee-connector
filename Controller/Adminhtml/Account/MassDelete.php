<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Controller\Adminhtml\Account;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Psr\Log\LoggerInterface;
use Upvado\ShopeeConnector\Model\ResourceModel\Account\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    public function __construct(
        private readonly CollectionFactory $collectionFactory,
        Context $context,
        private readonly Filter $filter,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        $collection = $this->collectionFactory->create();

        /**
         * @var Redirect $result
         */
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        try {
            $db = $this->filter->getCollection($collection);
        } catch (LocalizedException $localizedException) {
            $this->logger->error($localizedException->getMessage(), ['exception' => $localizedException]);
            $this->messageManager->addErrorMessage((string)__('There was a problem with the request.'));
            return $result->setPath('*/*');
        }

        $itemsSize = $db->count();

        foreach ($db as $item) {
            if (!is_object($item)) {
                continue;
            }

            if (method_exists($item, 'delete')) {
                $item->delete();
            }
        }

        $this->messageManager->addSuccessMessage(
            (string)__('A total of %1 record(s) have been deleted.', $itemsSize)
        );

        return $result->setPath('*/*');
    }
}
