<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInfoInterface;
use Rokezzz\CustomOrder\Api\TypeOrderInfoRepositoryInterface;

class TypeOrder implements ArgumentInterface
{

    public function __construct(
        private readonly TypeOrderInfoRepositoryInterface $typeOrderInfoRepository
    ) {
    }

    public function getTypeOrder(string $orderId): TypeOrderInfoInterface
    {
        return $this->typeOrderInfoRepository->getTypeOrderByOrderId($orderId);
    }
}
