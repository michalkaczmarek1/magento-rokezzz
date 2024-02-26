<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface TypeOrderSearchResultsInterface extends SearchResultsInterface
{

    public function getItems();

    public function setItems(array $items);
}
