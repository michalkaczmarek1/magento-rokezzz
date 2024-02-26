<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Rokezzz\CustomOrder\Model\TypeOrder::class, \Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder::class);
    }
}

