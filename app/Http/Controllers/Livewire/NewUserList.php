<?php

namespace App\Http\Controllers\Livewire;

use App\User;
use Livewire\Component;

class NewUserList extends Component
{
    /**
     * @var int
     */
    public $perPage = 5;
    /**
     * Sort direction
     *
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * Sort field
     *
     * @var null
     */
    public $sortField;


    public function render()
    {
        return view('frontend.livewire.new-user-list', ['users' => $this->getUsersProperty()])->layout('frontend.layouts.app');
    }

    /**
     * Get transactions
     *
     * @return mixed
     */
    public function getUsersProperty()
    {
        $query = User::newUsers();

        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($this->perPage);
    }

    /**
     * Sort by
     *
     * @param $field
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    /**
     * Return sort direction
     *
     * @param $column
     * @return string|null
     */
    public function sortDirection($column)
    {
        if ($column === $this->sortField) {
            return $this->sortDirection;
        }

        return null;
    }
}
