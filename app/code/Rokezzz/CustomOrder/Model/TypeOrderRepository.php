<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Checkout\Model\Session;
use Magento\Framework\Api\SearchResults;
use Magento\Quote\Model\MaskedQuoteIdToQuoteIdInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
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
        private readonly TypeOrderFactory                                   $modelFactory,
        private readonly Collection                                         $collectionFactory,
        private readonly SearchResults                                      $searchResults,
        private readonly CollectionProcessorInterface                       $collectionProcessor,
        private readonly Session                                            $checkoutSession,
        private readonly OrderRepositoryInterface                           $orderRepository,
        private readonly MaskedQuoteIdToQuoteIdInterface                    $maskedQuoteIdToQuoteId
    )
    {
    }

    public function save(
        TypeOrderInterface $typeOrder,
        string $cartId = null,
        string $name = null
    ): TypeOrderInterface
    {
        try {
            $typeOrderLoaded = $this->modelFactory->create();
            $this->resource->load($typeOrderLoaded, $typeOrder->getTypeOrderId());
            if ($typeOrderLoaded->getTypeOrderId() && $typeOrderLoaded->getOrderId()) {
                return $typeOrderLoaded;
            }

            if (!$typeOrder->getQuoteId()) {
                $quoteId = (string)$this->maskedQuoteIdToQuoteId->execute($cartId);
                $typeOrderLoaded->setQuoteId($quoteId);
            } else {
                $typeOrderLoaded->setQuoteId($typeOrder->getQuoteId());
            }

            $typeOrderLoaded->setName($typeOrder->getName() === null ? $name : $typeOrder->getName());
            $typeOrderLoaded->setOrderId($typeOrder->getOrderId());
            $typeOrderLoaded->setIncrementId($typeOrder->getIncrementId());
            $this->resource->save($typeOrderLoaded);
            return $typeOrderLoaded;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
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

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria): SearchResults
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

    /**
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $typeOrderId): bool
    {
        return $this->delete($this->getById($typeOrderId));
    }

    public function getByQuoteId(string $quoteId): TypeOrderInterface
    {
        $typeOrder = $this->modelFactory->create();
        $this->resource->load($typeOrder, $quoteId, 'quote_id');
        return $typeOrder;
    }

    public function getTypeOrderByOrderId(string $orderId): TypeOrderInterface
    {
        $typeOrder = $this->modelFactory->create();
        $this->resource->load($typeOrder, $orderId, 'order_id');
        return $typeOrder;
    }
}

