<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Plugin\Order;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Rokezzz\CustomOrder\Api\TypeOrderInfoRepositoryInterface;

class OrderRepository
{
    public function __construct(
        private readonly TypeOrderInfoRepositoryInterface $typeOrderInfoRepository
    ) {
    }

    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $entity): OrderInterface
    {
        $typeOrder = $this->typeOrderInfoRepository->getTypeOrderByOrderId($entity->getId());

        $extensionAttributes = $entity->getExtensionAttributes();
        $extensionAttributes->setTypeOrder($typeOrder);
        $entity->setExtensionAttributes($extensionAttributes);

        return $entity;
    }
}
