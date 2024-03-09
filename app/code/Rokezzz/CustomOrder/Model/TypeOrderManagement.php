<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInfoInterface;
use Rokezzz\CustomOrder\Api\TypeOrderManagementInterface;
use Rokezzz\CustomOrder\Api\TypeOrderInfoRepositoryInterface;

class TypeOrderManagement implements TypeOrderManagementInterface
{
    public function __construct(
        private readonly TypeOrderInfoRepositoryInterface $typeOrderInfoRepository,
        private readonly MaskedQuoteIdToQuoteIdInterface  $maskedQuoteIdToQuoteId,
        private readonly TypeOrderInfoFactory             $typeOrderInfoFactory
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
    ): TypeOrderInfoInterface {
        $typeOrderInfo = $this->typeOrderInfoFactory->create();
        $typeOrderInfo->setTypeOrderId($typeOrderId);
        $typeOrderInfo->setName($name);
        return $this->setQuoteId($typeOrderInfo, $cartId);
    }

    /**
     *
     * @throws NoSuchEntityException
     */
    private function setQuoteId(TypeOrderInfoInterface $typeOrderInfo, string $cartId): TypeOrderInfo
    {
        $quoteId = $this->maskedQuoteIdToQuoteId->execute($cartId);
        $typeOrderInfo->setQuoteId((string)$quoteId);
        $this->typeOrderInfoRepository->save($typeOrderInfo);
        return $typeOrderInfo;
    }
}
