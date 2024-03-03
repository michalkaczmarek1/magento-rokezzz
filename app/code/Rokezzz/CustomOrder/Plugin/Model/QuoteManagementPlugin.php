<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Plugin\Model;

use Magento\Quote\Model\QuoteManagement;
use Magento\Sales\Api\OrderRepositoryInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\CollectionFactory;

class QuoteManagementPlugin
{
    public function __construct(
        private readonly OrderRepositoryInterface     $orderRepository,
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    ) {
    }

    public function afterPlaceOrder(QuoteManagement $subject, int $orderId): int
    {
        $order = $this->orderRepository->get($orderId);
        $quoteId = $order->getQuoteId();
        $typeOrder = $this->typeOrderRepository->getTypeOrderByQuoteId((string)$quoteId);
        if (empty($typeOrder->getQuoteId())) {
            $typeOrder->setQuoteId($order->getQuoteId());
        }

        $typeOrder->setOrderId((string)$orderId);
        $typeOrder->setIncrementId($order->getIncrementId());
        if ($typeOrder->getQuoteId()) {
            $this->typeOrderRepository->save($typeOrder);
        }

        return $orderId;
    }
}
