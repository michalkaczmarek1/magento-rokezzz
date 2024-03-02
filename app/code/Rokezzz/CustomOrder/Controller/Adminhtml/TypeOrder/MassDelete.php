<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Controller\Adminhtml\TypeOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\CollectionFactory;

class MassDelete extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Magento_Sales::sales';

    protected CollectionFactory $collectionFactory;

    private TypeOrderRepositoryInterface $typeOrderRepository;

    protected Filter $filter;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        TypeOrderRepositoryInterface $typeOrderRepository
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->typeOrderRepository = $typeOrderRepository;
        parent::__construct($context);
    }

    public function execute(): Redirect
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $typeOrderDeleted = 0;
        foreach ($collection->getItems() as $typeOrder) {
            $this->typeOrderRepository->delete($typeOrder);
            $typeOrderDeleted++;
        }

        if ($typeOrderDeleted) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been deleted.', $typeOrderDeleted)
            );
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }
}
