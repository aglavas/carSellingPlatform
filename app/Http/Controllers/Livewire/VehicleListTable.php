<?php

namespace App\Http\Controllers\Livewire;

use App\Http\Controllers\Livewire\DataTable\WithPerPagePagination;
use App\StockVehicle;
use App\Traits\WithFilterableOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Brand;
use App\Service\EnquiryService;
use App\CartItem;
use App\Service\DataExport;
use Illuminate\Support\Facades\Response;

class VehicleListTable extends Component
{
    use WithPerPagePagination, WithFilterableOptions;

    /**
     * @var null|string
     */
    public $viewSwitch;

    /**
     * Selected rows
     *
     * @var array
     */
    public $selectedRows = [];


    /**
     * Select whole page flag
     *
     * @var null
     */
    public $selectPage;

    /**
     * Select all boolean
     *
     * @var null
     */
    public $selectAll;

    /**
     * Sort field
     *
     * @var null
     */
    public $sortField = 'created_at';

    /**
     * Free text search field
     *
     * @var null
     */
    public $search;

    /**
     * Sort direction
     *
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * Query string
     *
     * @var array
     */
    protected $queryString = ['sortField', 'sortDirection', 'search'];

    /**
     * @var Model
     */
    public $resource;

    /**
     * @var array
     */
    public $filters = [];

    /**
     * @var array
     */
    public $listColumns;

    /**
     * @var array
     */
    public $searchColumns;

    /**
     * @var \App\ColumnPreference
     */
    public $columnPreference;

    /**
     * @var string
     */
    public $resourceClass;

    /**
     * @var int
     */
    public $previewId;

    /**
     * @var Builder
     */
    private $carQuery;

    /**
     * @var Collection
     */
    public $brandCollection;

    /**
     * @var array
     */
    protected $listeners = ['refreshFilter', 'initializeFilters', 'refreshList', 'refreshSort', 'refreshPerPage'];

    /**
     * Mount the component
     *
     * @param Model $resource
     * @param string $resourceClass
     */
    public function mount(Model $resource, string $resourceClass)
    {
        $user = Auth::user();

        $this->listColumns = config("carmarket.frontend.columns.list");

        $columnPreference = $user->columnPreference($resourceClass)->first();

        if ($columnPreference) {
            $this->columnPreference = $this->getColumnArray($columnPreference);
        } else {
            $columnListCollection = collect($this->listColumns);

            $columnListCollection = $columnListCollection->filter(function ($item) {
               if ($item['default']) {
                   return $item;
               }
            });

            $columnListArray = $columnListCollection->pluck('column')->toArray();

            $this->columnPreference = array_fill_keys($columnListArray, true);
        }

        $this->resourceClass = $resourceClass;

        $this->resource = $resource;
        $this->listColumns = config("carmarket.frontend.columns.list");
        $this->searchColumns = config("carmarket.frontend.columns.search");
        $this->brandCollection = Brand::get()->map->only(['id', 'name'])->keyBy('id');
    }

    /**
     * Update selected
     */
    public function updatedSelected()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    /**
     * Select all
     */
    public function selectAll()
    {
        $this->selectAll = true;
    }

    /**
     * Get cars property
     *
     * @return mixed
     */
    public function getCarsProperty()
    {
        /** @var StockVehicle $this->resource */

        $query = $this->resource->query();

        $query->with(['cartData', 'enquiryData', 'deniedEnquiryData', 'bookmarks']);

        if (is_array($this->filters)) {
            $query = $this->applyFilters($query, $this->filters);
        }

        if ($this->sortField) {
            $query->orderBy($this->sortField, $this->sortDirection);
        }

        if ($this->search) {
            $searchArray = explode(' ', $this->search);

            $searchArray = array_filter($searchArray);

            $columns = $this->searchColumns;

            if (count($searchArray) === 1) {
                $query->where(function($query) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhereRaw("UPPER($column) like '%" . strtoupper($this->search) . "%'");
                    }
                });
            } elseif (count($searchArray) > 1) {
                $query->where(function($query) use ($columns, $searchArray) {
                    foreach ($searchArray as $searchTerm) {
                        foreach ($columns as $column) {
                            $query->orWhereRaw("UPPER($column) like '%" . strtoupper($searchTerm) . "%'");
                        }
                    }
                });
            }
        }

        $query->withoutReserved();

        $this->carQuery = clone($query);

        return $query->paginate($this->perPage);
    }

    /**
     * Render template
     *
     * @return mixed
     */
    public function render()
    {
        if ($this->selectAll) {
            $cars = $this->cars;

            $this->selectedRows = $this->carQuery->pluck('manufacturer_id')->map(function ($id) {
                return (string)$id;
            });
        }

        $templateName = 'frontend.livewire.vehicle-list-table';

        return view($templateName, [
            'cars' => $this->cars
        ])->layout('frontend.layouts.app');
    }

    /**
     * Refresh filter
     *
     * @param $filters
     */
    public function refreshFilter($filters)
    {
        $this->resetPage();

        $this->filters = $filters;
    }

    /**
     * Refresh sort
     *
     * @param $sortArray
     */
    public function refreshSort($sortArray)
    {
        if (isset($sortArray['sortField'])) {
            $this->sortField = $sortArray['sortField'];
        }

        if (isset($sortArray['sortDirection'])) {
            $this->sortDirection = $sortArray['sortDirection'];
        }
    }

    /**
     * Refresh per page
     *
     * @param $perPage
     */
    public function refreshPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * Refresh vehicle list
     */
    public function refreshList()
    {
        $user = Auth::user();

        $columnPreference = $user->columnPreference($this->resourceClass)->first();

        if ($columnPreference) {
            $this->columnPreference = $this->getColumnArray($columnPreference);
        } else {
            $this->columnPreference = null;
        }

        $this->render();
    }

    /**
     * Get column array
     *
     * @param \App\ColumnPreference $columnPreference
     * @return mixed
     */
    private function getColumnArray(\App\ColumnPreference $columnPreference)
    {
        $columnArray = $columnPreference->columns;

        foreach ($columnArray as $column => $value) {
            if (!$value) {
                unset($columnArray[$column]);
            }
        }

        return $columnArray;
    }

    /**
     * Initialize selected values into filter
     *
     * @param $filters
     */
    public function initializeFilters($filters)
    {
        $this->filters = $filters;
    }

    /**
     * Remove filter value
     *
     * @param $data
     */
    public function removeFilterValue($data)
    {
        $newValuesArray = array_values(array_diff($this->filters[$data[0]]['values'], [$data[1]]));
        $this->emitUp('filterToggled', ['column' => $data[0], 'values' => $newValuesArray]);
    }

    /**
     * Return brand label
     *
     * @param $id
     * @return mixed
     */
    public function brandLabel($id)
    {
        $brand = $this->brandCollection[$id]['name'];

        return $brand;
    }

    /**
     * Select or unselect the whole page
     *
     * @param $value
     */
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selectedRows = $this->cars->pluck('manufacturer_id')->map(function ($id) {
                return (string)$id;
            });
        } else {
            $this->selectedRows = [];
            $this->selectAll = false;
        }
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
     * View type switcher
     *
     * @param $value
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatedViewSwitch($value)
    {
        if ($value == 'card-view') {
            return redirect()->route('vehicle-search');
        }
    }

    /**
     * Add selected vehicles to cart
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function addSelectedToCart()
    {
        $query = $this->resource->query();

        $collection = $query->whereKey($this->selectedRows)->get();

        $collection->each(function($vehicle) {
            if (EnquiryService::validateEnquiry($vehicle) && !$vehicle->inCart()) {
                CartItem::firstOrCreate(
                    [
                        'vehicle_type' => get_class($vehicle),
                        'user_id' => Auth::user()->id,
                        'vehicle_ident' => $vehicle->{$vehicle->identColumn}
                    ]
                );
            }
        });

        $this->emit('cartCountChanged');
    }

    /**
     * Export selected files
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function exportSelected()
    {
        $dataExport = new DataExport($this->resource);

        $user = Auth::user();

        $query = $this->resource->query();

        $collection = $query->whereKey($this->selectedRows)->get();

        $filePath = $dataExport->export($collection);

        activity('export_success')
            ->performedOn($this->resource)
            ->withProperties(['rows' => count($collection), 'filters' => $this->filters])
            ->causedBy($user)
            ->log('Export success.');

        return Response::download($filePath, $this->resource->exportFileName);
    }

}
