<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder as TypeOrderResource;
use Rokezzz\CustomOrder\Model\TypeOrder;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(TypeOrder::class, TypeOrderResource::class);
    }
}
