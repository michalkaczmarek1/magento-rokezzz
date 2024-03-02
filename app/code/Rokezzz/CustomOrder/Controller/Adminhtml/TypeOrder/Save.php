<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Rokezzz\CustomOrder\Model\TypeOrderFactory;

class Save extends Action implements HttpPostActionInterface
{
    public function __construct(
        Context                                       $context,
        private readonly DataPersistorInterface       $dataPersistor,
        private readonly TypeOrderFactory             $typeOrderFactory,
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    )
    {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $data = $data['type_order_data'];
        if ($data) {
            if (empty($data['type_order_id'])) {
                $data['type_order_id'] = null;
            }
            $model = $this->typeOrderFactory->create();

            $id = $this->getRequest()->getParam('type_order_id');
            if ($id) {
                try {
                    $model = $this->typeOrderRepository->getById((int) $id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This type order no longer exists.'));
                    return $resultRedirect->setPath('*/*/index');
                }
            }

            $model->setData($data);
            try {
                $typeOrder = $this->typeOrderRepository->save($model);
                if($typeOrder) {
                    $this->messageManager->addSuccessMessage(__('You saved the type order.'));
                    $this->dataPersistor->clear('type_order');
                    return $this->processTypeOrderReturn($model, $data, $resultRedirect);
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the type order.'));
            }

            $this->dataPersistor->set('type_order', $data);
            return $resultRedirect->setPath('*/*/edit', ['type_order_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/index');
    }

    private function processTypeOrderReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['type_order_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/index');
        }

        return $resultRedirect;
    }
}
