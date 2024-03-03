<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\Source\Option;

use Magento\Framework\Data\OptionSourceInterface;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\CollectionFactory;

class TypeOrder implements OptionSourceInterface
{
    public function __construct(
        private readonly CollectionFactory $typeOrderCollection
    ) {
    }

    public function toOptionArray(): array
    {
        $items = $this->getTypeOrders();
        $types = [];
        if (count($items) > 0) {
            foreach ($items as $typeOrder) {
                $types[] = ['label' => $typeOrder['name'], 'value' => $typeOrder['type_order_id']];
            }
        }

        return $types;
    }

    private function getTypeOrders(): array
    {
        $collection = $this->typeOrderCollection->create();
        $collection->getSelect()->group('name')->distinct(true);
        return $collection->addFieldToFilter('order_id', ['null' => true])->getItems();
    }
}
