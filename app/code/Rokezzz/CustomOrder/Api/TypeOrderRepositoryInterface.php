<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderSearchResultsInterface;

interface TypeOrderRepositoryInterface
{
    /**
     * @param SearchCriteriaInterface $searchSearchCriteria
     * @return TypeOrderSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults;


    /**
     * @param int ?$typeOrderId
     * @return TypeOrderInterface
     */
    public function getById(?int $typeOrderId): TypeOrderInterface;

    /**
     * @param string $orderId
     * @return TypeOrderInterface
     */
    public function getTypeOrderByOrderId(string $orderId): TypeOrderInterface;

    /**
     * @param string $orderId
     * @return TypeOrderInterface
     */
    public function getTypeOrderByQuoteId(string $orderId): TypeOrderInterface;


    /**
     * @param TypeOrderInterface $typeOrder
     * @return bool
     */
    public function delete(TypeOrderInterface $typeOrder): bool;


    /**
     * @param TypeOrderInterface $typeOrder
     * @param string $cartId
     * @return TypeOrderInterface
     */
    public function save(TypeOrderInterface $typeOrder, string $typeOrderId, string $cartId, string $name): ?TypeOrderInterface;
}

