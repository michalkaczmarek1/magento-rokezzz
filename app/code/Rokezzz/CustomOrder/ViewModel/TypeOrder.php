<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;

class TypeOrder implements ArgumentInterface
{
    public function __construct(
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    ) {}

    public function getTypeOrderByOrderId(string $orderId): TypeOrderInterface
    {
        return $this->typeOrderRepository->getTypeOrderByOrderId($orderId);
    }
}
