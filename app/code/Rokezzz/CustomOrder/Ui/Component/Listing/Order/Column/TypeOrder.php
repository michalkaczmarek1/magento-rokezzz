<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Ui\Component\Listing\Order\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Rokezzz\CustomOrder\Api\TypeOrderRepositoryInterface;

class TypeOrder extends Column
{
    public function __construct(
        ContextInterface         $context,
        UiComponentFactory       $uiComponentFactory,
        private readonly TypeOrderRepositoryInterface $typeOrderRepository,
        array                    $components = [],
        array                    $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $typeOrder = $this->typeOrderRepository->getTypeOrderByOrderId($item["entity_id"]);
                $item[$this->getData('name')] = $typeOrder->getName();
            }
        }

        return $dataSource;
    }
}
