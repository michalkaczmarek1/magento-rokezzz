<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model;

use DateTime;
use Magento\Framework\Model\AbstractModel;
use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;

class TypeOrder extends AbstractModel implements TypeOrderInterface
{
    private int $typeOrderId;
    private string $name;
    private int $orderId;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    protected function _construct()
    {
        $this->_init(\Rokezzz\CustomOrder\Model\ResourceModel\TypeOrder::class);
    }

    public function getTypeOrderId(): int
    {
        return $this->typeOrderId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
