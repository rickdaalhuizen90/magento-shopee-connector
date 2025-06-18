<?php

declare(strict_types=1);

namespace Upvado\ShopeeConnector\Ui\DataProvider\Account\Form\Modifier;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Upvado\ShopeeConnector\Api\ShopRepositoryInterface;

class General implements ModifierInterface
{
    public function __construct(
        readonly private ShopRepositoryInterface $shopRepository
    ) {}

    public function modifyMeta(array $meta)
    {
        return $meta;
    }

    public function modifyData(array $data): array
    {
        try {
            $shop = $this->shopRepository->getById((int) $data['shop_id']);
        } catch (NoSuchEntityException) {
            return [];
        }

        return [
            'general' => $shop->toArray(),
        ];
    }
}
