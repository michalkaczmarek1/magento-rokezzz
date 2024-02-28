<?php

namespace Rokezzz\CustomOrder\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;

class OrderRepositoryPlugin
{
    public function __construct(
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    ) {}
    public function afterGet
    (
        OrderRepositoryInterface $subject,
        OrderInterface           $entity
    )
    {
        $ourCustomData = $subject->get($entity->getId());

        $extensionAttributes = $entity->getExtensionAttributes();
        /** get current extension attributes from entity **/
        $extensionAttributes->setOurCustomData($ourCustomData);
        $this->typeOrderRepository->getById(1);
        $entity->setExtensionAttributes($extensionAttributes);

        return $entity;
    }

    public function afterGetList(
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $searchResults
    ) : OrderSearchResultInterface {
        $orders = [];
        foreach ($searchResults->getItems() as $entity) {
            $ourCustomData = $subject->get($entity->getId());

            $extensionAttributes = $entity->getExtensionAttributes();
            $extensionAttributes->setOurCustomData($ourCustomData);
            $entity->setExtensionAttributes($extensionAttributes);

            $orders[] = $entity;
        }
        $searchResults->setItems($orders);
        return $searchResults;
    }

    public function afterSave
    (
        OrderRepositoryInterface $subject,
        OrderInterface $result, /** result from the save call **/
        OrderInterface $entity  /** original parameter to the call **/
        /** other parameter not required **/
    ) {
        $extensionAttributes = $entity->getExtensionAttributes(); /** get original extension attributes from entity **/
//        $typeOrder = $extensionAttributes->getTypeOrder();
//        $this->typeOrderRepository->save($typeOrder);

        $resultAttributes = $result->getExtensionAttributes();
        /** get extension attributes as they exist after save **/
//        $resultAttributes->setTypeOrderId($typeOrder); /** update the extension attributes with correct data **/
        $result->setExtensionAttributes($resultAttributes);

        return $result;
    }
}
