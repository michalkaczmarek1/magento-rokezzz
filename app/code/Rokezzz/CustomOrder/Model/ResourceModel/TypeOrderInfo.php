<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TypeOrderInfo extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('type_order_info', 'entity_id');
    }
}
