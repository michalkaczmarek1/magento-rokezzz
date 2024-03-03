<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\App\Area;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\State;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder as TypeOrderResource;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\Collection;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class TypeOrderRepository implements TypeOrderRepositoryInterface
{
    public function __construct(
        private readonly TypeOrderResource               $resource,
        private readonly TypeOrderFactory                $modelFactory,
        private readonly Collection                      $collectionFactory,
        private readonly SearchResults                   $searchResults,
        private readonly CollectionProcessorInterface    $collectionProcessor,
        private readonly MaskedQuoteIdToQuoteIdInterface $maskedQuoteIdToQuoteId,
        private readonly State                           $state
    ) {
    }

    /**
     *
     * @throws CouldNotSaveException
     */
    public function save(
        TypeOrderInterface $typeOrder,
        string             $typeOrderId = null,
        string             $cartId = null
    ): TypeOrderInterface {
        try {
            $typeOrderLoaded = $this->modelFactory->create();
            if ($this->state->getAreaCode() === Area::AREA_ADMINHTML) {
                $this->saveTypeOrderInAdminArea($typeOrder, $typeOrderLoaded);
            }

            if ($this->state->getAreaCode() === Area::AREA_WEBAPI_REST) {
                $typeOrderWithOrderId = $this->saveTypeOrderWithOrderId($typeOrder);
                if (!empty($typeOrderWithOrderId)) {
                    return $typeOrderWithOrderId;
                }

                $this->saveQuoteIdOnTypeOrder($typeOrderLoaded, $typeOrderId, $cartId);
                $this->resource->save($typeOrderLoaded);
            }

            return !empty($typeOrderLoaded->getTypeOrderId()) ? $typeOrderLoaded : $typeOrder;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
    }

    public function getById(?int $typeOrderId): TypeOrderInterface
    {
        $typeOrder = $this->modelFactory->create();
        $this->resource->load($typeOrder, $typeOrderId);
        if (!$typeOrder->getId()) {
            throw new NoSuchEntityException(__('The type order with the "%1" ID doesn\'t exist.', $typeOrderId));
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

    public function getTypeOrderByOrderId(string $orderId): TypeOrderInterface
    {
        $typeOrder = $this->modelFactory->create();
        $this->resource->load($typeOrder, $orderId, 'order_id');
        return $typeOrder;
    }

    public function getTypeOrderByQuoteId(string $quoteId): TypeOrderInterface
    {
        $typeOrder = $this->modelFactory->create();
        $this->resource->load($typeOrder, $quoteId, 'quote_id');
        return $typeOrder;
    }

    /**
     *
     * @throws AlreadyExistsException
     */
    private function saveTypeOrderWithOrderId(TypeOrderInterface $typeOrder): ?TypeOrderInterface
    {
        if (($typeOrder->getOrderId() && $typeOrder->getTypeOrderId()) && !empty($typeOrder->getQuoteId())) {
            $this->resource->save($typeOrder);
            return $typeOrder;
        }

        return null;
    }

    /**
     *
     * @throws NoSuchEntityException
     */
    private function saveQuoteIdOnTypeOrder(TypeOrder $typeOrderLoaded, ?string $typeOrderId, ?string $cartId): void
    {
        $this->resource->load($typeOrderLoaded, (int)$typeOrderId);
        if (!$typeOrderLoaded->getQuoteId() && $cartId) {
            $quoteId = (string)$this->maskedQuoteIdToQuoteId->execute($cartId);
            $typeOrderLoaded->setQuoteId($quoteId);
        }
    }

    /**
     *
     * @throws AlreadyExistsException
     */
    private function saveTypeOrderInAdminArea(
        TypeOrderInterface $typeOrder,
        TypeOrder $typeOrderLoaded
    ): TypeOrderInterface {
        if ($typeOrder->getTypeOrderId()) {
            $this->resource->save($typeOrder);
            return $typeOrder;
        } else {
            $typeOrderLoaded->setName($typeOrder->getName());
            $this->resource->save($typeOrderLoaded);
            return $typeOrderLoaded;
        }
    }
}
