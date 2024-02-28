<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api\Data;

use DateTime;

interface TypeOrderInterface
{
    /**
     * @return ?string
     */
    public function getTypeOrderId(): ?string;

    /**
     * @return string
     */
    public function getName(): ?string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(?string $name): void;

    /**
     * @return string
     */
    public function getIncrementId(): ?string;

    /**
     * @param ?string $incrementId
     * @return void
     */
    public function setIncrementId(?string $incrementId): void;

    /**
     * @return string
     */
    public function getOrderId(): ?string;

    /**
     * @param ?string $orderId
     * @return void
     */
    public function setOrderId(?string $orderId): void;

    /**
     * @return int
     */
    public function getQuoteId(): ?string;

    /**
     * @param ?int $quoteId
     * @return void
     */
    public function setQuoteId(?string $quoteId): void;

    /**
     * @return string
     */
    public function getCreatedAt(): ?string;

    /**
     * @return string
     */
    public function getUpdatedAt(): ?string;
}
