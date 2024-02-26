<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TypeOrder extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('type_order', 'type_order_id');
    }
}

