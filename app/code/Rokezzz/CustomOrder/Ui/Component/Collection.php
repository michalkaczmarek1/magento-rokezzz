<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Ui\Component;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    protected function _initSelect(): void
    {
        $this->addFilterToMap('type_order_id', 'main_table.type_order_id');
        parent::_initSelect();
    }
}
