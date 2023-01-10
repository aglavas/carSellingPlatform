<?php

namespace Efdi\LocalMultiselectFilter;

use Laravel\Nova\Filters\Filter;


abstract class LocalMultiselectFilter extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'local-multiselect-filter';
}
