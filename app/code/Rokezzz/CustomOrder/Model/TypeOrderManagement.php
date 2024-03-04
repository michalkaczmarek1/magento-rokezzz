<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;
use Rokezzz\CustomOrder\Api\TypeOrderManagementInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;

class TypeOrderManagement implements TypeOrderManagementInterface
{
    public function __construct(
        private readonly TypeOrderRepositoryInterface $typeOrderRepository,
        private readonly MaskedQuoteIdToQuoteIdInterface $maskedQuoteIdToQuoteId,
        private readonly TypeOrderFactory $typeOrderFactory
    ) {
    }

    /**
     *
     * @throws NoSuchEntityException
     */
    public function save(
        string $typeOrderId,
        string $name,
        string $cartId
    ): TypeOrderInterface {
        $typeOrder = $this->typeOrderFactory->create();
        $typeOrder->setName($name);
        return $this->setQuoteId($typeOrder, $cartId);
    }

    /**
     *
     * @throws NoSuchEntityException
     */
    private function setQuoteId(TypeOrderInterface $typeOrder, string $cartId): TypeOrder
    {
        $quoteId = $this->maskedQuoteIdToQuoteId->execute($cartId);
        $typeOrder->setQuoteId((string)$quoteId);
        $this->typeOrderRepository->save($typeOrder);
        return $typeOrder;
    }
}
