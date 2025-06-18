<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model;

use Magento\Framework\Model\AbstractModel;
use Upvado\ShopeeConnector\Api\Data\TokenInterface;
use Upvado\ShopeeConnector\Model\ResourceModel\Token as TokenResourceModel;

class Token extends AbstractModel implements TokenInterface
{
    protected function _construct()
    {
        $this->_init(TokenResourceModel::class);
    }

    public function getAccessToken(): string
    {
        return (string)$this->getData('access_token');
    }

    public function setAccessToken(string $accessToken): TokenInterface
    {
        return $this->setData('access_token', $accessToken);
    }

    public function getExpiresAt(): int
    {
        return (int)$this->getData('expires_at');
    }

    public function setExpiresAt(int $expiresAt): TokenInterface
    {
        return $this->setData('expires_at', $expiresAt);
    }

    public function getUserId(): int
    {
        return (int)$this->getData('user_id');
    }

    public function setUserId(int $userId): TokenInterface
    {
        return $this->setData('user_id', $userId);
    }

    public function getStoreId(): int
    {
        return (int)$this->getData('store_id');
    }

    public function setStoreId(int $storeId): TokenInterface
    {
        return $this->setData('store_id', $storeId);
    }

    public function getGrantType(): string
    {
        return (string)$this->getData('grant_type');
    }

    public function setGrantType(string $grantType): TokenInterface
    {
        return $this->setData('grant_type', $grantType);
    }

    public function getRefreshToken(): string
    {
        return (string)$this->getData('refresh_token');
    }

    public function setRefreshToken(string $refreshToken): TokenInterface
    {
        return $this->setData('refresh_token', $refreshToken);
    }
}
