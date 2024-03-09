<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Plugin\Model;

use Magento\Quote\Model\QuoteManagement;
use Magento\Sales\Api\OrderRepositoryInterface;
use Rokezzz\CustomOrder\Api\TypeOrderInfoRepositoryInterface;

class SaveOrderPlugin
{
    public function __construct(
        private readonly OrderRepositoryInterface     $orderRepository,
        private readonly TypeOrderInfoRepositoryInterface $typeOrderInfoRepository
    ) {
    }

    public function afterPlaceOrder(QuoteManagement $subject, int $orderId): int
    {
        if (!empty($orderId)) {
            $this->saveOrderOnTypeOrder($orderId);
        }

        return $orderId;
    }

    private function saveOrderOnTypeOrder(int $orderId): void
    {
        try {
            $order = $this->orderRepository->get($orderId);
            $quoteId = $order->getQuoteId();
            $typeOrder = $this->typeOrderInfoRepository->getTypeOrderByQuoteId((string)$quoteId);
            $typeOrder->setOrderId((string)$orderId);
            if ($typeOrder->getQuoteId()) {
                $this->typeOrderInfoRepository->save($typeOrder);
            }
        } catch (\Exception $exception) {
            return;
        }
    }
}
