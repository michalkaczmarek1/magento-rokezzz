<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder as TypeOrderResource;
use Rokezzz\CustomOrder\Model\TypeOrder as TypeOrderModel;
use Rokezzz\CustomOrder\Model\TypeOrderFactory;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'Rokezzz_CustomOrder::typeorder';

    public function __construct(
        Context                           $context,
        private readonly Registry         $coreRegister,
        private readonly TypeOrderResource    $typeOrderResource,
        private readonly TypeOrderFactory $typeOrderFactory,
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('type_order_id');
        $typeOrder = $this->typeOrderFactory->create();
        if ($id) {
            $this->typeOrderResource->load($typeOrder, $id);
            if (!$typeOrder->getTypeOrderId()) {
                $this->messageManager->addErrorMessage(__('This type_order no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/index');
            }
        }

        return $this->configPageAndRedirect($typeOrder, $id);
    }

    private function configPageAndRedirect(TypeOrderModel $typeOrder, int $id)
    {
        $this->coreRegister->register('type_order', $typeOrder);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $id ? __('Edit Type Order ') : __('Add Type Order');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
