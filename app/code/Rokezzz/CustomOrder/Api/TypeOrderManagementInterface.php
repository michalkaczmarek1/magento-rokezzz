<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api;

use Rokezzz\CustomOrder\Api\Data\TypeOrderInterface;

interface TypeOrderManagementInterface
{

    /**
     *
     * @param string $typeOrderId
     * @param string $name
     * @param string $cartId
     * @return TypeOrderInterface
     */
    public function save(
        string $typeOrderId,
        string $name,
        string $cartId
    ): TypeOrderInterface;
}
