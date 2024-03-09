<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResults;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Exception\AlreadyExistsException;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInfoInterface;
use Rokezzz\CustomOrder\Api\TypeOrderInfoRepositoryInterface;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrderInfo as TypeOrderInfoResource;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\Collection;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class TypeOrderInfoRepository implements TypeOrderInfoRepositoryInterface
{
    public function __construct(
        private readonly TypeOrderInfoResource               $resource,
        private readonly TypeOrderInfoFactory                $modelFactory,
        private readonly Collection                      $collectionFactory,
        private readonly SearchResults                   $searchResults,
        private readonly CollectionProcessorInterface    $collectionProcessor,
        private readonly State                           $state
    ) {
    }

    /**
     *
     * @throws CouldNotSaveException
     */
    public function save(TypeOrderInfoInterface $typeOrderInfo): TypeOrderInfoInterface
    {
        try {
            if ($this->state->getAreaCode() === Area::AREA_ADMINHTML) {
                return $this->saveTypeOrderInAdminArea($typeOrderInfo);
            }

            $typeOrderInfoWithOrderId = $this->saveTypeOrderWithOrderId($typeOrderInfo);
            if (!empty($typeOrderInfoWithOrderId)) {
                return $typeOrderInfoWithOrderId;
            }

            $this->resource->save($typeOrderInfo);
            return $typeOrderInfo;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getById(?int $typeOrderInfoId): TypeOrderInfoInterface
    {
        $typeOrderInfo = $this->modelFactory->create();
        $this->resource->load($typeOrderInfo, $typeOrderInfoId);
        if (!$typeOrderInfo->getId()) {
            throw new NoSuchEntityException(__('The type order with the "%1" ID doesn\'t exist.', $typeOrderInfoId));
        }

        return $typeOrderInfo;
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
    public function delete(TypeOrderInfoInterface $typeOrderInfo): bool
    {
        try {
            $this->resource->delete($typeOrderInfo);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $typeOrderInfoId): bool
    {
        return $this->delete($this->getById($typeOrderInfoId));
    }

    public function getTypeOrderByOrderId(string $orderId): TypeOrderInfoInterface
    {
        $typeOrderInfo = $this->modelFactory->create();
        $this->resource->load($typeOrderInfo, $orderId, 'order_id');
        return $typeOrderInfo;
    }

    public function getTypeOrderByQuoteId(string $quoteId): TypeOrderInfoInterface
    {
        $typeOrderInfo = $this->modelFactory->create();
        $this->resource->load($typeOrderInfo, $quoteId, 'quote_id');
        return $typeOrderInfo;
    }

    /**
     *
     * @throws AlreadyExistsException
     */
    private function saveTypeOrderWithOrderId(TypeOrderInfoInterface $typeOrderInfo): ?TypeOrderInfoInterface
    {
        if ((
                $typeOrderInfo->getOrderId()
                && $typeOrderInfo->getTypeOrderId())
                && !empty($typeOrderInfo->getQuoteId())) {
            $this->resource->save($typeOrderInfo);
            return $typeOrderInfo;
        }

        return null;
    }

    /**
     *
     * @throws AlreadyExistsException
     */
    private function saveTypeOrderInAdminArea(
        TypeOrderInfoInterface $typeOrderInfo,
    ): TypeOrderInfoInterface {
        if ($typeOrderInfo->getTypeOrderId()) {
            $this->resource->save($typeOrderInfo);
            return $typeOrderInfo;
        } else {
            $typeOrderInfo->setName($typeOrderInfo->getName());
            $this->resource->save($typeOrderInfo);
            return $typeOrderInfo;
        }
    }
}
