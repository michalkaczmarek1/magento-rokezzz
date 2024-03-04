<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;

interface TypeOrderRepositoryInterface
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
     * @return TypeOrderInterface
     */
    public function getById(?int $typeOrderId): TypeOrderInterface;

    /**
     *
     * @param string $orderId
     * @return TypeOrderInterface
     */
    public function getTypeOrderByOrderId(string $orderId): TypeOrderInterface;

    /**
     *
     * @param string $quoteId
     * @return TypeOrderInterface
     */
    public function getTypeOrderByQuoteId(string $quoteId): TypeOrderInterface;

    /**
     *
     * @param TypeOrderInterface $typeOrder
     * @return bool
     */
    public function delete(TypeOrderInterface $typeOrder): bool;

    /**
     *
     * @param TypeOrderInterface $typeOrder
     * @return TypeOrderInterface
     */
    public function save(TypeOrderInterface $typeOrder): TypeOrderInterface;
}
