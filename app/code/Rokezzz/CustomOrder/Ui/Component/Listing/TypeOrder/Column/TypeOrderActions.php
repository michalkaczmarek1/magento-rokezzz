<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Ui\Component\Listing\TypeOrder\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class TypeOrderActions extends Column
{
    private const URL_PATH_EDIT = 'type_order_grid/typeorder/edit';

    private const URL_PATH_DELETE = 'type_order_grid/typeorder/delete';

    public function __construct(
        ContextInterface              $context,
        UiComponentFactory            $uiComponentFactory,
        private readonly UrlInterface $urlBuilder,
        private readonly Escaper      $escaper,
        array                         $components = [],
        array                         $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['type_order_id'])) {
                    $name = $this->escaper->escapeHtmlAttr($item['name']);
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_EDIT,
                                [
                                    'type_order_id' => $item['type_order_id']
                                ]
                            ),
                            'label' => __('Edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                self::URL_PATH_DELETE,
                                [
                                    'type_order_id' => $item['type_order_id']
                                ]
                            ),
                            'label' => __('Delete'),
                            'confirm' => [
                                'title' => __('Delete %1', $name),
                                'message' => __('Are you sure you want to delete a %1 record?', $name)
                            ],
                            'post' => true
                        ],
                    ];
                }
            }
        }

        return $dataSource;
    }
}
