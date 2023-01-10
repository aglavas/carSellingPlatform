<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;

trait Export
{
    /**
     * @param null $exportData
     * @return array
     */
    public function prepareExport($exportData = null)
    {
        $exportClass = $this->exportClass;

        try {
            $exportObject = new $exportClass($exportData);

            return $exportObject->prepareExport($this);
        } catch (\Exception $exception) {
            return Action::danger('Something went wrong! Export class not defined.');
        }
    }
}
