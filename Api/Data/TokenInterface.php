<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api\Data;

interface TokenInterface
{
    /**
     * Get access token
     *
     * @return string
     */
    public function getAccessToken(): string;

    /**
     * Set access token
     *
     * @param string $accessToken
     * @return $this
     */
    public function setAccessToken(string $accessToken): self;

    /**
     * Get token expiration timestamp
     *
     * @return int
     */
    public function getExpiresAt(): int;

    /**
     * Set token expiration timestamp
     *
     * @param int $expiresAt
     * @return $this
     */
    public function setExpiresAt(int $expiresAt): self;

    /**
     * Get user ID
     *
     * @return int
     */
    public function getUserId(): int;

    /**
     * Set user ID
     *
     * @param int $userId
     * @return $this
     */
    public function setUserId(int $userId): self;

    /**
     * Get store ID
     *
     * @return int
     */
    public function getStoreId(): int;

    /**
     * Set store ID
     *
     * @param int $storeId
     * @return $this
     */
    public function setStoreId(int $storeId): self;

    /**
     * Get grant type
     *
     * @return string
     */
    public function getGrantType(): string;

    /**
     * Set grant type
     *
     * @param string $grantType
     * @return $this
     */
    public function setGrantType(string $grantType): self;

    /**
     * Get refresh token
     *
     * @return string
     */
    public function getRefreshToken(): string;

    /**
     * Set refresh token
     *
     * @param string $refreshToken
     * @return $this
     */
    public function setRefreshToken(string $refreshToken): self;
}
