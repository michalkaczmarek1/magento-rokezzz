<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInfoInterface;

interface TypeOrderInfoRepositoryInterface
{
    /**
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResults
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;

    /**
     *
     * @param int|null $typeOrderId
     * @return TypeOrderInfoInterface
     */
    public function getById(?int $typeOrderId): TypeOrderInfoInterface;

    /**
     *
     * @param string $orderId
     * @return TypeOrderInfoInterface
     */
    public function getTypeOrderByOrderId(string $orderId): TypeOrderInfoInterface;

    /**
     *
     * @param string $quoteId
     * @return TypeOrderInfoInterface
     */
    public function getTypeOrderByQuoteId(string $quoteId): TypeOrderInfoInterface;

    /**
     *
     * @param TypeOrderInfoInterface $typeOrder
     * @return bool
     */
    public function delete(TypeOrderInfoInterface $typeOrder): bool;

    /**
     *
     * @param TypeOrderInfoInterface $typeOrder
     * @return TypeOrderInfoInterface
     */
    public function save(TypeOrderInfoInterface $typeOrder): TypeOrderInfoInterface;
}
