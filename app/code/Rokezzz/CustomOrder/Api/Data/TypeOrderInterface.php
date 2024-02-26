<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api\Data;

use DateTime;

interface TypeOrderInterface
{
    public function getTypeOrderId(): int;

    public function getName(): string;

    public function setName(string $name): void;

    public function getOrderId(): int;

    public function setOrderId(int $orderId): void;

    public function getCreatedAt(): DateTime;

    public function getUpdatedAt(): DateTime;

}
