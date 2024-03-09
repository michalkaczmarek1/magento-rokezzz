<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\App\State;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder as TypeOrderGridResource;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class TypeOrderRepository implements TypeOrderRepositoryInterface
{
    public function __construct(
        private readonly TypeOrderGridResource               $resource,
        private readonly TypeOrderFactory                $modelFactory,
        private readonly CollectionFactory                      $collectionFactory,
        private readonly SearchResults                   $searchResults,
        private readonly CollectionProcessorInterface    $collectionProcessor
    ) {
    }

    /**
     *
     * @throws CouldNotSaveException
     */
    public function save(TypeOrderInterface $typeOrder): TypeOrderInterface
    {
        try {
            $this->resource->save($typeOrder);
            return $typeOrder;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById(?int $typeOrderGridId): TypeOrderInterface
    {
        $typeOrder = $this->modelFactory->create();
        $this->resource->load($typeOrder, $typeOrderGridId);
        if (!$typeOrder->getId()) {
            throw new NoSuchEntityException(__('The type order with the "%1" ID doesn\'t exist.', $typeOrderGridId));
        }

        return $typeOrder;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): SearchResults
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $this->searchResults->setSearchCriteria($searchCriteria);
        $this->searchResults->setItems($collection->getItems());
        $this->searchResults->setTotalCount($collection->getSize());

        return $this->searchResults;
    }

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(TypeOrderInterface $typeOrder): bool
    {
        try {
            $this->resource->delete($typeOrder);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $typeOrderId): bool
    {
        return $this->delete($this->getById($typeOrderId));
    }
}
