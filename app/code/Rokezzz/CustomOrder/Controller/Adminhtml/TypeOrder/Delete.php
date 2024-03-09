<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;

class Delete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Rokezzz_CustomOrder::typeorder';
    private const GRID_URL = '*/*/index';

    public function __construct(
        Context                                       $context,
        private readonly TypeOrderRepositoryInterface $typeOrderRepository
    ) {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam('type_order_id');
        if ($id) {
            try {
                $this->deleteTypeOrder($id);
                return $resultRedirect->setPath(self::GRID_URL);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['type_order_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a type order to delete.'));
        return $resultRedirect->setPath(self::GRID_URL);
    }

    private function deleteTypeOrder(int $id): void
    {
        $typeOrder = $this->typeOrderRepository->getById($id);
        $this->typeOrderRepository->delete($typeOrder);
        $this->messageManager->addSuccessMessage(__('You deleted the type order.'));
    }
}
