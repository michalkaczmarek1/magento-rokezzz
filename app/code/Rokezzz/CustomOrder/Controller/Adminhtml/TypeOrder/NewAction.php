<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;

class NewAction extends Action implements HttpGetActionInterface
{
    protected ForwardFactory $resultForwardFactory;

    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultForwardFactory->create()->forward('edit');
    }
}
