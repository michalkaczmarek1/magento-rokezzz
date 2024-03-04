<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\OptionSourceInterface;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder\CollectionFactory;

class TypeOrder implements OptionSourceInterface
{
    public function __construct(
        private readonly CollectionFactory $typeOrderCollection,
        private readonly ScopeConfigInterface $scopeConfig
    ) {
    }

    public function toOptionArray($isMultiselect = true)
    {
        $items = $this->getTypeOrders();
        $options = [];
        foreach ($items as $item) {
            $options[] = ['value' => $item->getTypeOrderId(), 'label' => $item->getName()];
        }

        return $options;
    }

    private function getTypeOrders(): array
    {
        $collection = $this->typeOrderCollection->create();
        $collection->getSelect()->group('name')->distinct(true);
        return $collection->getItems();
    }
}
