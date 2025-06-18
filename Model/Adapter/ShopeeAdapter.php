<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Model\Adapter;

use Upvado\ShopeeClient\ClientBuilder;
use Upvado\ShopeeClient\Security\Authentication;
use Upvado\ShopeeClient\Type\Environment;
use Upvado\ShopeeClient\Type\Region;
use Upvado\ShopeeConnector\Config\Config;
use Upvado\ShopeeConnector\Model\Shop;
use Magento\Framework\Exception\LocalizedException;
use Upvado\ShopeeClient\Exception\AuthenticationException;
use Upvado\ShopeeConnector\Api\TokenRepositoryInterface;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;

class ShopeeAdapter
{
    public function __construct(
        private readonly TokenRepositoryInterface $tokenRepository,
        private readonly ClientBuilder $clientBuilder,
        private readonly CacheInterface $cache,
        private readonly SerializerInterface $serializer,
        private readonly Config $config,
    ) {
    }

    public function getConnection(Shop $shop)
    {
        $region = Region::tryFrom((string) $shop->getRegion());

        try {
            $token = $this->tokenRepository->get($shop->getId());
        } catch (LocalizedException) {
            throw new AuthenticationException(
                sprintf('Authorization token not found for shop ID: %s. Please authorize the shop.', $shop->getId())
            );
        }

        $auth = new Authentication($this->config->getPartnerId(), $this->config->getPartnerSecret(), '');

        $client = $this->clientBuilder
            ->setRegion($region)
            ->setEnvironment(Environment::from($this->config->getEnvrionment()))
            ->build($auth);

        $client->auth->setShopId($shop->getId());
        $client->auth->setAccessToken($token->getAccessToken());

        return $client;
    }

    public function getOrdersByShop(Shop $shop): array
    {
        $cacheKey = "shopee:order:{$shop->getId()}";
        $cached = $this->cache->load($cacheKey);

        if (json_validate($cached)) {
            return $this->serializer->unserialize($cached);
        }

        $client = $this->getConnection($shop);
        $orders = $client->order->getOrderList();
        $this->cache->save(data: $orders, identifier: $cacheKey, lifeTime: 300);
        
        return $this->serializer->unserialize($orders);
    }
}