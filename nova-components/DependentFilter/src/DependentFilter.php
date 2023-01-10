<?php

namespace Efdi\DependentFilter;

use Illuminate\Http\Request;

class DependentFilter extends \AwesomeNova\Filters\DependentFilter
{

    public $multiple = false;

    public $range = false;

    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'dependent-filter';

    public function multiple($multiple)
    {
        $this->multiple = $multiple;
        return $this;
    }

    public function range($range)
    {
        $this->range = $range;
        return $this;
    }

    /**
     * Prepare the filter for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge([
            'class' => $this->key(),
            'name' => $this->name(),
            'component' => $this->component(),
            'options' => count($this->dependentOf) === 0 ? $this->getOptions(app(Request::class)) : [],
            'currentValue' => $this->default() ?? '',
            'dependentOf' => $this->dependentOf,
            'hideWhenEmpty' => $this->hideWhenEmpty,
            'multiple' => $this->multiple,
            'range' => $this->range
        ], $this->meta());
    }
}
