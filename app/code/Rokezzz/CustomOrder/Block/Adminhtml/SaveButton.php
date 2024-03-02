<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Block\Adminhtml;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Ui\Component\Control\Container;

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return [
            'label' => __('Save'),
            'class' => 'save primary',
//            'on_click' => sprintf("location.href = '%s';", $this->getSaveUrl()),
            'data_attribute' => [
                'mage-init' => [
                    'buttonAdapter' => [
                        'actions' => [
                            [
                                'targetName' => 'type_order_form.type_order_form',
                                'actionName' => 'save',
                                'params' => [
                                    true,
                                    [
                                        'back' => 'continue'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
        ];
    }

    public function getSaveUrl(): string
    {
        return $this->getUrl('type_order_grid_/type_order/save');
    }
}
