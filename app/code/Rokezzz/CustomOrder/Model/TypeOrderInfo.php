<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInfoInterface;

class TypeOrderInfo extends AbstractModel implements TypeOrderInfoInterface
{
    private const ENTITY_ID = 'entity_id';

    private const TYPE_ORDER_ID = 'type_order_id';

    private const NAME = 'name';

    private const ORDER_ID = 'order_id';

    private const QUOTE_ID = 'quote_id';

    private const CREATED_AT = 'created_at';

    private const UPDATED_AT = 'updated_at';

    protected function _construct()
    {
        $this->_init(ResourceModel\TypeOrderInfo::class);
    }

    public function getEntityId(): ?string
    {
        return $this->getData(self::ENTITY_ID);
    }

    public function getTypeOrderId(): ?string
    {
        return $this->getData(self::TYPE_ORDER_ID);
    }

    public function setTypeOrderId(?string $typeOrderId): void
    {
        $this->setData(self::TYPE_ORDER_ID, $typeOrderId);
    }

    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function getOrderId(): ?string
    {
        return $this->getData(self::ORDER_ID);
    }

    public function setOrderId(?string $orderId): void
    {
        $this->setData(self::ORDER_ID, $orderId);
    }

    public function getQuoteId(): ?string
    {
        return $this->getData(self::QUOTE_ID);
    }

    public function setQuoteId(?string $quoteId): void
    {
        $this->setData(self::QUOTE_ID, $quoteId);
    }
}
