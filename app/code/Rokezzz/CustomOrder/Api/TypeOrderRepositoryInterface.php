<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api;

use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;

interface TypeOrderRepositoryInterface
{
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    public function getById(int $id);

    public function delete(TypeOrderInterface $entity);

    public function save(TypeOrderInterface $entity);
}

