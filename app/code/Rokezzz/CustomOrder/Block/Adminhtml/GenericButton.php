<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Block\Adminhtml;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected Context $context;

    protected TypeOrderRepositoryInterface $typeOrderRepository;
    private DataPersistorInterface $dataPersistor;

    public function __construct(
        Context                      $context,
        TypeOrderRepositoryInterface $typeOrderRepository
    )
    {
        $this->context = $context;
        $this->typeOrderRepository = $typeOrderRepository;
    }


//    public function getId()
//    {
//        $typeOrder = $this->dataPersistor->get('type_order');
//        return $typeOrder ? $type->getId() : null;
//    }
    public function getTypeOrderId(): ?string
    {
        try {
            return $this->typeOrderRepository->getById(
                (int) $this->context->getRequest()->getParam('type_order_id')
            )->getTypeOrderId();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getUrl($route = '', $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
