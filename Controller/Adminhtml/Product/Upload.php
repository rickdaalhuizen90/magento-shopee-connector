<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Controller\Adminhtml\Product;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Result\PageFactory;

class Upload implements HttpGetActionInterface
{
    public function __construct(
        private readonly PageFactory $resultPageFactory,
        private readonly Http $request
    ) {}

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        dd($this->request->getParams());
        return $resultPage;
    }
}
