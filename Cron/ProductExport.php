<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Cron;

use Psr\Log\LoggerInterface;

class ProductExport
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function execute(): void
    {
        // Export products to Shopee
        $this->logger->info('sync products');
    }
}
