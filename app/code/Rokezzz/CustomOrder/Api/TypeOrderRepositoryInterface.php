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
     * @param int|null $typeOrderGridId
     * @return TypeOrderInterface
     */
    public function getById(?int $typeOrderGridId): TypeOrderInterface;

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
