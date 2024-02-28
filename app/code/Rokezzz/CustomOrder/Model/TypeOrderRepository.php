<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Framework\Api\SearchResults;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderSearchResultsInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\Collection;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class TypeOrderRepository implements TypeOrderRepositoryInterface
{

    public function __construct(
        private readonly \Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder $resource,
        private readonly TypeOrderFactory                                          $modelFactory,
        private readonly Collection                                         $collectionFactory,
        private readonly SearchResults                                      $searchResults,
        private readonly CollectionProcessorInterface                       $collectionProcessor,
    )
    {
    }

    public function save(string $name, int $typeOrderId): TypeOrderInterface
    {
        try {
            $typeOrder = $this->modelFactory->create();
            $this->resource->load($typeOrder, $typeOrderId);
            if($typeOrder->getTypeOrderId()) {
                return $typeOrder;
            }
            $typeOrder->setName($name);
            $this->resource->save($typeOrder);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $typeOrder;
    }

    public function getById(int $typeOrderId): TypeOrderInterface
    {
        $typeOrder = $this->modelFactory->create();
        $this->resource->load($typeOrder, $typeOrderId);
        if (!$typeOrder->getId()) {
            throw new NoSuchEntityException(__('The type order with the "%1" ID doesn\'t exist.', $typeOrderId));
        }
        return $typeOrder;
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria): TypeOrderSearchResultsInterface
    {
        /** @var ResourceModel\TypeOrder\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var TypeOrderSearchResultsInterface $searchResults */
        $this->searchResults->setSearchCriteria($criteria);
        $this->searchResults->setItems($collection->getItems());
        $this->searchResults->setTotalCount($collection->getSize());
        return $this->searchResults;
    }

    public function delete(TypeOrderInterface $typeOrder): bool
    {
        try {
            $this->resource->delete($typeOrder);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById(int $typeOrderId): bool
    {
        return $this->delete($this->getById($typeOrderId));
    }
}

