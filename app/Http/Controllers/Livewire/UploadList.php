<?php

namespace App\Http\Controllers\Livewire;

use App\StockListUpload;
use Livewire\Component;

class UploadList extends Component
{
    /**
     * @var int
     */
    public $perPage;
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

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.upload-list', ['uploads' => $this->getUploadsProperty()]);
    }

    /**
     * Get transactions
     *
     * @return mixed
     */
    public function getUploadsProperty()
    {
        $query = StockListUpload::ofUser()->with('uploader');

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

    /**
     * Delete the upload
     *
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        $upload = StockListUpload::find($id);

        unlink(storage_path('app/public/'. $upload->file_path));

        $upload->delete();
    }
}
