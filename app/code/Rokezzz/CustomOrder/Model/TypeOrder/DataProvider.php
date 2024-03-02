<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\TypeOrder;

use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\CollectionFactory;

class DataProvider extends ModifierPoolDataProvider
{

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $typeOrderCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $typeOrderCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();
        foreach ($items as $typeOrder) {
            $this->loadedData[$typeOrder->getId()]['type_order_data'] = $typeOrder->getData();
        }

        return $this->loadedData;

    }
}
