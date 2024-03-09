<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\ResourceModel\TypeOrderInfo;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Rokezzz\CustomOrder\Model\ResourceModel\TypeOrderInfo as TypeOrderInfoResource;
use Rokezzz\CustomOrder\Model\TypeOrderInfo as TypeOrderInfoModel;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(TypeOrderInfoModel::class, TypeOrderInfoResource::class);
    }
}
