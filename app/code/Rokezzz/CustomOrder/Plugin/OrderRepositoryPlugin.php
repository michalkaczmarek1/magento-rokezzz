<?php

namespace Rokezzz\CustomOrder\Plugin;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;

class OrderRepositoryPlugin
{
    public function __construct(
        private readonly TypeOrderRepositoryInterface $typeOrderRepository,
    )
    {
    }

//    public function afterGet
//    (
//        OrderRepositoryInterface $subject,
//        OrderInterface           $entity
//    )
//    {
//        $ourCustomData = $subject->get($entity->getId());
//
//        $extensionAttributes = $entity->getExtensionAttributes();
//        /** get current extension attributes from entity **/
//        $extensionAttributes->setOurCustomData($ourCustomData);
//        $this->typeOrderRepository->getById(1);
//        $entity->setExtensionAttributes($extensionAttributes);
//
//        return $entity;
//    }
//
//    public function afterGetList(
//        OrderRepositoryInterface   $subject,
//        OrderSearchResultInterface $searchResults
//    ): OrderSearchResultInterface
//    {
//        $orders = [];
//        foreach ($searchResults->getItems() as $entity) {
//            $ourCustomData = $subject->get($entity->getId());
//
//            $extensionAttributes = $entity->getExtensionAttributes();
//            $extensionAttributes->setOurCustomData($ourCustomData);
//            $entity->setExtensionAttributes($extensionAttributes);
//
//            $orders[] = $entity;
//        }
//        $searchResults->setItems($orders);
//        return $searchResults;
//    }

    /**
     * @throws CouldNotSaveException
     */
    public function afterSave(
        \Magento\Sales\Api\OrderRepositoryInterface $subject,
        \Magento\Sales\Api\Data\OrderInterface      $result
    ): OrderInterface
    {
//        $extensionAttributes = $result->getExtensionAttributes(); /** get original extension attributes from entity **/
//        $typeOrder = $extensionAttributes->getTypeOrder();
//        $this->typeOrderRepository->save(
//            $typeOrder->getTypeOrderId(),
//            $typeOrder->getName()
//        );

        $typeOrder = $this->typeOrderRepository->getByQuoteId($result->getQuoteId());
        $typeOrder->setOrderId($result->getEntityId());
        $typeOrder->setIncrementId($result->getIncrementId());
        $typeOrder = $this->typeOrderRepository->save($typeOrder);
        $resultAttributes = $result->getExtensionAttributes(); /** get extension attributes as they exist after save **/
        $resultAttributes->setTypeOrder($typeOrder); /** update the extension attributes with correct data **/
        $result->setExtensionAttributes($resultAttributes);

        return $result;
    }

    /**
     * @throws CouldNotSaveException
     */
    private function saveTypeOrder(\Magento\Sales\Api\Data\OrderInterface $order): OrderInterface
    {
        $extensionAttributes = $order->getExtensionAttributes();
        if (
            null !== $extensionAttributes &&
            null !== $extensionAttributes->getTypeOrder()
        ) {
            $typeOrder = $extensionAttributes->getTypeOrder();
            try {
                $this->typeOrderRepository->save($typeOrder->getTypeOrderId(), $order->getIncrementId());
            } catch (\Exception $e) {
                throw new CouldNotSaveException(
                    __('Could not add attribute to order: "%1"', $e->getMessage()),
                    $e
                );
            }
        }
        return $order;
    }
}
