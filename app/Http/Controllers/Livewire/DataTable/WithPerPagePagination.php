<?php

namespace App\Http\Controllers\Livewire\DataTable;

use Livewire\WithPagination;

trait WithPerPagePagination
{
    use WithPagination;

    /**
     * @var int
     */
    public $perPage = 40;

    /**
     * Mount per page
     */
    public function mountWithPerPagePagination()
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    /**
     * Update per page
     *
     * @param $value
     */
    public function updatedPerPage($value)
    {
        session()->put('perPage', $value);
    }
}
