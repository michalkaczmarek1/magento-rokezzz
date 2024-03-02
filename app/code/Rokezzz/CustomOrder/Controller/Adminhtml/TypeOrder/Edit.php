<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder;
use Rokezzz\CustomOrder\Model\TypeOrderFactory;

class Edit extends Action implements HttpGetActionInterface
{
    protected PageFactory $resultPageFactory;
    private Registry $coreRegister;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $coreRegister,
        private readonly TypeOrder $typeOrderResource,
        private readonly TypeOrderFactory $typeOrderFactory,
    ) {

        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegister = $coreRegister;
    }

    public function execute()
    {
        $id = (int) $this->getRequest()->getParam('type_order_id');
        $typeOrder = $this->typeOrderFactory->create();
        if ($id) {
            $this->typeOrderResource->load($typeOrder, $id);
            if (!$typeOrder->getId()) {
                $this->messageManager->addErrorMessage(__('This type_order no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('type_order_grid/typeorder/index');
            }
        }

        $this->coreRegister->register('type_order', $typeOrder);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $id ? __('Edit Type Order ') : __('Add Type Order');
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
