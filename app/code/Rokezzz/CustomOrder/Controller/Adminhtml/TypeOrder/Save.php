<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Rokezzz\CustomOrder\Model\TypeOrderFactory;

class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Rokezzz_CustomOrder::typeorder';

    private const GRID_URL = '*/*/index';

    /**
     *
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param TypeOrderFactory $typeOrderFactory
     * @param TypeOrderRepositoryInterface $typeOrderRepository
     */
    public function __construct(
        Context                                       $context,
        private readonly DataPersistorInterface       $dataPersistor,
        private readonly TypeOrderFactory             $typeOrderFactory,
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        $data = $data['type_order_data'];
        if ($data) {
            $data['type_order_id'] = empty($data['type_order_id']) ? null : $data['type_order_id'];
            $model = $this->typeOrderFactory->create();
            $id = $this->getRequest()->getParam('type_order_id');
            if ($id) {
                try {
                    $model = $this->typeOrderRepository->getById((int)$id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This type order no longer exists.'));
                    return $resultRedirect->setPath(self::GRID_URL);
                }
            }

            return $this->saveTypeOrderAndRedirect($model, $data, $resultRedirect, $id);
        }

        return $resultRedirect->setPath(self::GRID_URL);
    }

    private function saveTypeOrderAndRedirect(
        TypeOrderInterface $model,
        array              $data,
        Redirect           $resultRedirect,
        ?int                $id
    ): Redirect {
        try {
            $model->setData($data);
            $typeOrder = $this->typeOrderRepository->save($model);
            if ($typeOrder->getTypeOrderId()) {
                $this->messageManager->addSuccessMessage(__('You saved the type order.'));
                $this->dataPersistor->clear('type_order');
                return $resultRedirect->setPath(self::GRID_URL);
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the type order.'));
        }

        $this->dataPersistor->set('type_order', $data);
        return $resultRedirect->setPath('*/*/edit', ['type_order_id' => $id]);
    }
}
