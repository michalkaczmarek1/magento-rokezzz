<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TypeOrderSearchResultsInterface extends SearchResultsInterface
{

    /**
     * @return mixed
     */
    public function getItems();

    /**
     * @param array $items
     * @return mixed
     */
    public function setItems(array $items);
}
