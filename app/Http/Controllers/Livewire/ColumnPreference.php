<?php

namespace App\Http\Controllers\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\ColumnPreference as ColumnPreferenceModel;

class ColumnPreference extends Component
{
    /**
     * @var array
     */
    public $columnList;

    /**
     * @var string
     */
    public $resourceClass;

    /**
     * @var array
     */
    public $selectedColumns = [];

    /**
     * Mount the component
     *
     * @param array $listColumns
     * @param array $columnPreference
     * @param string $resourceClass
     */
    public function mount(array $listColumns, array $columnPreference, string $resourceClass)
    {
        $this->columnList = $listColumns;
        $this->resourceClass = $resourceClass;

        if ($columnPreference) {
            $this->selectedColumns = $columnPreference;
        } else {
            $columnListArray = collect($this->columnList)->pluck('column')->toArray();

            $this->selectedColumns = array_fill_keys($columnListArray, true);
        }
    }

    /**
     * Save column preferences
     */
    public function saveColumnPreferences()
    {
        $user = Auth::user();

        ColumnPreferenceModel::updateOrCreate([
           'user_id' => $user->id,
            'vehicle_type' => $this->resourceClass
        ],[
            'columns' => $this->selectedColumns
        ]);

        $this->emit('refreshList');
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.column-preference');
    }
}
