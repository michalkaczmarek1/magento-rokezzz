<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api;

use Rokezzz\CustomOrder\Api\Data\TypeOrderInfoInterface;

interface TypeOrderManagementInterface
{

    /**
     *
     * @param string $typeOrderId
     * @param string $name
     * @param string $cartId
     * @return TypeOrderInfoInterface
     */
    public function save(
        string $typeOrderId,
        string $name,
        string $cartId
    ): TypeOrderInfoInterface;
}
