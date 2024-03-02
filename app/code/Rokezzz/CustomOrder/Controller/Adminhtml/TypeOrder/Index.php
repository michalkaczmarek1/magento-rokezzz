<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action implements HttpGetActionInterface
{
    private PageFactory $pageFactory;

    public function __construct(
        Context $context,
        PageFactory $rawFactory
    ) {
        $this->pageFactory = $rawFactory;
        parent::__construct($context);
    }

    public function execute(): Page
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('Magento_Sales::sales');
        $resultPage->getConfig()->getTitle()->prepend(__('Type Orders'));

        return $resultPage;
    }
}
