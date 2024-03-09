<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api\Data;

interface TypeOrderInfoInterface
{

    /**
     *
     * @return ?string
     */
    public function getEntityId(): ?string;

    /**
     *
     * @return ?string
     */
    public function getTypeOrderId(): ?string;

    /**
     *
     * @return ?string
     */
    public function setTypeOrderId(?string $typeOrderId): void;

    /**
     *
     * @return ?string
     */
    public function getName(): ?string;

    /**
     *
     * @param ?string $name
     * @return void
     */
    public function setName(?string $name): void;

    /**
     *
     * @return ?string
     */
    public function getOrderId(): ?string;

    /**
     *
     * @param ?string $orderId
     * @return void
     */
    public function setOrderId(?string $orderId): void;

    /**
     *
     * @return ?string
     */
    public function getQuoteId(): ?string;

    /**
     *
     * @param ?string $quoteId
     * @return void
     */
    public function setQuoteId(?string $quoteId): void;

    /**
     *
     * @return ?string
     */
    public function getCreatedAt(): ?string;

    /**
     *
     * @return ?string
     */
    public function getUpdatedAt(): ?string;
}
