<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderSearchResultsInterface;

interface TypeOrderRepositoryInterface
{
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return TypeOrderSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): TypeOrderSearchResultsInterface;


    /**
     * @param int $id
     * @return TypeOrderInterface
     */
    public function getById(int $id): TypeOrderInterface;


    /**
     * @param string $quoteId
     * @return TypeOrderInterface
     */
    public function getByQuoteId(string $quoteId): TypeOrderInterface;

    /**
     * @param TypeOrderInterface $entity
     * @return TypeOrderInterface
     */
    public function delete(TypeOrderInterface $entity): bool;


    /**
     * @param TypeOrderInterface $typeOrder
     * @param string $cartId
     * @return TypeOrderInterface
     */
    public function save(TypeOrderInterface $typeOrder, string $cartId, string $name): TypeOrderInterface;

//    /**
//     * @param TypeOrderInterface $entity
//     * @return TypeOrderInterface
//     */
//    public function save(TypeOrderInterface $entity): TypeOrderInterface;
}

