<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public function __construct(private readonly ScopeConfigInterface $scopeConfig) {}

    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag('shopee_connector/general/enabled', ScopeInterface::SCOPE_STORE);
    }

    public function getEnvrionment(): int
    {
        return (int) $this->scopeConfig->getValue('shopee_connector/general/environment', ScopeInterface::SCOPE_STORE);
    }

    public function getPartnerId(): int
    {
        return (int) $this->scopeConfig->getValue('shopee_connector/general/partner_id', ScopeInterface::SCOPE_STORE);
    }

    public function getPartnerSecret(): string
    {
        return (string) $this->scopeConfig->getValue('shopee_connector/general/partner_secret', ScopeInterface::SCOPE_STORE);
    }

    public function getSandboxPartnerId(): string
    {
        return (string) $this->scopeConfig->getValue('shopee_connector/general/sandbox_partner_id', ScopeInterface::SCOPE_STORE);
    }

    public function getSandboxPartnerSecret(): string
    {
        return (string) $this->scopeConfig->getValue('shopee_connector/general/sandbox_partner_secret', ScopeInterface::SCOPE_STORE);
    }

    public function isDebugLogsEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag('shopee_connector/debugging/enable_debug_logs', ScopeInterface::SCOPE_STORE);
    }
}
