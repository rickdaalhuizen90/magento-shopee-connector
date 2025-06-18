<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Block\Adminhtml\Edit\Button;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Generic implements ButtonProviderInterface
{
    public function __construct(protected Context $context)
    {
    }

    public function getBlockId(): string
    {
        return '';
    }

    public function getButtonData(): array
    {
        return [];
    }

    /**
     * Generate url by route and parameters
     *
     * @param array<string, int|null> $params
     */
    protected function getUrl(string $route = '', array $params = []): string // phpcs:ignore
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
