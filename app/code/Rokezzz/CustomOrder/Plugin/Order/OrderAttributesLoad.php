<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Plugin\Order;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderExtensionInterface;
use Magento\Sales\Api\Data\OrderInterface;

class OrderAttributesLoad
{
    public function __construct(private readonly OrderExtensionFactory $extensionFactory)
    {
    }

    public function afterGetExtensionAttributes(
        OrderInterface          $entity,
        OrderExtensionInterface $extension = null
    ) {
        if ($extension === null) {
            $extension = $this->extensionFactory->create();
        }

        return $extension;
    }
}
