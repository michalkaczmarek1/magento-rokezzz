<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\Source\Option;

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

    public function toOptionArray(): array
    {
        return $this->getTypeOrders();
    }

    private function getTypeOrders(): array
    {
        $typeOrderIds = $this->scopeConfig->getValue('sales/type_orders/type_orders');
        $arrTypeOrderIds = explode(',', $typeOrderIds);
        $types = [];
        foreach ($arrTypeOrderIds as $typeOrderId) {
            $collection = $this->typeOrderCollection->create();
            $typeOrder = $collection->addFieldToFilter('type_order_id', ['type_order_id' => $typeOrderId])->getItems();
            foreach ($typeOrder as $value) {
                $types[] = ['label' => $value->getName(), 'value' => $value->getTypeOrderId()];
            }
        }

        return $types;
    }
}
