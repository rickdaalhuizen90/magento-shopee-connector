<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Api;

use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeConnector\Api\Data\TokenInterface;

interface TokenRepositoryInterface
{
    /**
     * Save OAuth token
     *
     * @param TokenInterface $token
     * @return TokenInterface
     * @throws LocalizedException
     */
    public function save(TokenInterface $token): TokenInterface;

    /**
     * Retrieve OAuth token
     *
     * @param string $accessToken
     * @return TokenInterface
     * @throws LocalizedException
     */
    public function get(string $accessToken): TokenInterface;

    /**
     * Delete OAuth token
     *
     * @return bool
     */
    public function delete(TokenInterface $token): bool;

    /**
     * Check if token is expired
     *
     * @param TokenInterface $token
     * @return bool
     */
    public function isExpired(TokenInterface $token): bool;
}
