<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;

class GetOrderDataObserver implements ObserverInterface
{
    public function __construct(
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    ) {}

    public function execute(Observer $observer): void
    {
        $order = $observer->getData('order');
        $typeOrder = $this->typeOrderRepository->getTypeOrderByQuoteId($order->getQuoteId());
        $typeOrder->setOrderId($order->getId());
        $typeOrder->setIncrementId($order->getIncrementId());
        $this->typeOrderRepository->save($typeOrder);
    }
}
