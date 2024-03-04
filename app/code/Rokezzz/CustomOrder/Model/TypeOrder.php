<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;

class TypeOrder extends AbstractModel implements TypeOrderInterface
{
    private const TYPE_ORDER_ID = 'type_order_id';

    private const NAME = 'name';

    private const INCREMENT_ID = 'increment_id';

    private const ORDER_ID = 'order_id';

    private const QUOTE_ID = 'quote_id';

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

    public function getIncrementId(): ?string
    {
        return $this->getData(self::INCREMENT_ID);
    }

    public function setIncrementId(?string $incrementId): void
    {
        $this->setData(self::INCREMENT_ID, $incrementId);
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
