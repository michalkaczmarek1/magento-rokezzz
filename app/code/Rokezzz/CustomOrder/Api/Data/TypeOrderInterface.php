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
    public function getName(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;
}
