<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Plugin\Block\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;
use Rokezzz\CustomOrder\Model\Source\Option\TypeOrder;

class TypeOrderProcessorPlugin
{
    public function __construct(
        private readonly TypeOrder $typeOrderOptions
    )
    {
    }

    public function afterProcess(LayoutProcessor $subject, array $jsLayout): array
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['before-form']['children']['type_order'] = [
            'component' => 'Magento_Ui/js/form/element/checkbox-set',
            'config' => [
                'customScope' => 'customCheckoutForm',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/checkbox-set',
                'options' => $this->typeOrderOptions->toOptionArray(),
                'multiple' => false
            ],
            'dataScope' => 'shippingAddress.type_order',
            'label' => __('Type Order'),
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 200,
            'id' => 'type_order'
        ];


        return $jsLayout;
    }
}
