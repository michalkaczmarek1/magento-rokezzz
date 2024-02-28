<?php declare(strict_types=1);

namespace Rokezzz\CustomOrder\Model\Source\Option;

class TypeOrder
{

    /**#@-*/
    protected $options = [];

    public function __construct(
        array $options
    )
    {
        $this->options = $options;
    }

    public function toOptionArray()
    {
        $types = [];
        foreach ($this->options as $value => $label) {
            $types[] = ['label' => $label, 'value' => $value];
        }
        return $types;
    }
}
