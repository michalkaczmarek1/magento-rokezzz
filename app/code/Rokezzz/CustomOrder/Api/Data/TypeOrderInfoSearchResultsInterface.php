<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TypeOrderInfoSearchResultsInterface extends SearchResultsInterface
{

    /**
     *
     * @return array
     */
    public function getItems(): array;

    /**
     *
     * @param array $items
     * @return array
     */
    public function setItems(array $items): array;
}
