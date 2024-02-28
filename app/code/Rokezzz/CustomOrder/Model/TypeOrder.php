<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use DateTime;
use Magento\Framework\Model\AbstractModel;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;

class TypeOrder extends AbstractModel implements TypeOrderInterface
{
    private const TYPE_ORDER_ID = 'type_order_id';
    private const NAME = 'name';

    private const CREATED_AT = 'created_at';
    private const UPDATED_AT = 'updated_at';

    protected function _construct()
    {
        $this->_init(ResourceModel\TypeOrder::class);
    }

    public function getTypeOrderId(): ?string
    {
        return $this->getData(self::TYPE_ORDER_ID);
    }

    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    public function setName(string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }
}
