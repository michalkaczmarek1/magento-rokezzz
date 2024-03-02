<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;

class Delete extends Action implements HttpPostActionInterface
{
    public function __construct(
        Context                                       $context,
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    )
    {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int) $this->getRequest()->getParam('type_order_id');
        if ($id) {
            try {
                $typeOrder = $this->typeOrderRepository->getById($id);
                $this->typeOrderRepository->delete($typeOrder);
                $this->messageManager->addSuccessMessage(__('You deleted the type order.'));

                return $resultRedirect->setPath('*/*/index');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('type_order_grid/typeorder/edit', ['type_order_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a type order to delete.'));
        return $resultRedirect->setPath('*/*/index');
    }
}
