<?php

namespace App\Http\Controllers\Livewire;

use App\Service\DataExport;
use App\Traits\WithFilterableOptions;
use App\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Support\Facades\Response;
use Livewire\WithPagination;
use App\Actions\ApproveTransaction;
use App\Actions\DenyTransaction;

class TransactionsList extends Component
{
    use WithFilterableOptions, WithPagination;

    /**
     * @var int
     */
    public $perPage = 40;

    /**
     * @var array
     */
    public $listeners = ['filterToggled', 'initializeFilters', 'refreshSort', 'refreshPerPage'];

    /**
     * @var array
     */
    public $filters = [];

    /**
     * Free text search field
     *
     * @var null
     */
    public $search;

    /**
     * @var array
     */
    public $searchColumns = [
        'buyer' => [
            "car_data->>'brand'",
            "car_data->>'model'",
            "car_data->>'version_description'",
            "car_data->>'manufacturer_id'",
            "cast(car_data->>'price_in_euro' AS TEXT)",
            "car_data->>'company'",
        ],
        'seller' => [
            "car_data->>'brand'",
            "car_data->>'model'",
            "car_data->>'version_description'",
            "car_data->>'manufacturer_id'",
            "cast(car_data->>'price_in_euro' AS TEXT)",
            'cast(buyer_id AS TEXT)',
        ],
        'admin' => [
            "car_data->>'brand'",
            "car_data->>'model'",
            "car_data->>'version_description'",
            "car_data->>'manufacturer_id'",
            "cast(car_data->>'price_in_euro' AS TEXT)",
            "car_data->>'company'",
            'cast(buyer_id AS TEXT)',
        ],
    ];

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $listType;

    /**
     * @var bool
     */
    public $selectPage;

    /**
     * @var bool
     */
    public $selectAll;

    /**
     * @var array
     */
    public $selectedRows = [];

    /**
     * Sort field
     *
     * @var null
     */
    public $sortField = 'created_at';

    /**
     * Sort direction
     *
     * @var string
     */
    public $sortDirection = 'desc';

    /**
     * @var Builder
     */
    protected $query;

    /**
     * Query string
     *
     * @var array
     */
    protected $queryString = ['sortField', 'sortDirection'];

    /**
     * Mount the component
     */
    public function mount()
    {
        $this->filters = [];
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $viewFile = null;

        if ($this->type === 'buyer') {
            $viewFile = 'frontend.livewire.transaction-list.buyer';
        } else if ($this->type === 'seller') {
            $viewFile = 'frontend.livewire.transaction-list.seller';
        } else {
            $viewFile = 'frontend.livewire.transaction-list.admin';
        }

        return view(
            $viewFile,
            [
                'vehicles' => $this->getVehiclesProperty()
            ]
        );
    }

    /**
     * Build transaction query
     *
     * @return Builder|mixed
     */
    private function buildQuery()
    {
        if ($this->type === 'seller') {
            $baseTransactions = Transaction::ofSeller();
        } elseif ($this->type === 'buyer') {
            $baseTransactions = Transaction::ofBuyer();
        } else {
            $baseTransactions = Transaction::query();
        }

        if ($this->listType === 'enquiry') {
            $baseTransactions->whereIn('status', [Transaction::TRANSACTION_STATUS_DENIED, Transaction::TRANSACTION_STATUS_IN_PROGRESS, Transaction::TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION]);
        } elseif ($this->listType === 'order') {
            $baseTransactions->where('status', '=', Transaction::TRANSACTION_STATUS_APPROVED);
        }

        $baseTransactions = $this->applyFilters($baseTransactions, $this->filters);

        if ($this->sortField) {
            $baseTransactions->orderBy($this->sortField, $this->sortDirection);
        }

        return $baseTransactions;
    }

    /**
     * Get vehicles
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Builder|mixed
     */
    public function getVehiclesProperty()
    {
        $baseTransactions = $this->buildQuery();

        if ($this->search) {
            $searchArray = explode(' ', $this->search);

            $searchArray = array_filter($searchArray);

            $columns = $this->searchColumns[$this->type];

            if (count($searchArray) === 1) {
                $baseTransactions->where(function($query) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhereRaw("$column ilike '%" . strtoupper($this->search) . "%'");
                    }
                });
            } elseif (count($searchArray) > 1) {
                $baseTransactions->where(function($query) use ($columns, $searchArray) {
                    foreach ($searchArray as $searchTerm) {
                        foreach ($columns as $column) {
                            $query->orWhereRaw("$column ilike '%" . strtoupper($searchTerm) . "%'");
                        }
                    }
                });
            }
        }

        $enquiryGroupCollection = $baseTransactions->get()->groupBy('enquiry_id');

        $enquiryGroupArray = [];

        foreach ($enquiryGroupCollection as $enquiryId => $items) {
            $enquiryGroupArray[$enquiryId] = count($items);
        }

        $baseTransactions = $baseTransactions->paginate($this->perPage);

        $resultCollection = collect([]);
        foreach ($baseTransactions->items() as $transaction) {
            $vehicle = $transaction->vehicle;

            if ($vehicle) {
                $vehicle->enquiry_id = $transaction->enquiry_id;
                $vehicle->enquiry_count = $enquiryGroupArray[$transaction->enquiry_id];
                $vehicle->transaction_status = $transaction->status;
                $vehicle->transaction_id = $transaction->id;
                $vehicle->buyer = $transaction->buyer->name;
                $vehicle->transaction_updated_at = $transaction->updated_at;
                $resultCollection->push($vehicle);
            } else {
                $transaction->status = Transaction::TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION;
                $transaction->save();
                $vehicle = $transaction->car_data;
                $vehicle['enquiry_id'] = $transaction->enquiry_id;
                $vehicle['enquiry_count'] = $enquiryGroupArray[$transaction->enquiry_id];
                $vehicle['buyer'] = $transaction->buyer->name;
                $vehicle['vehicle_type'] = $transaction->vehicle_type;
                $vehicle['transaction_updated_at'] = $transaction->updated_at;
                $vehicle['transaction_status'] = Transaction::TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION;
                $resultCollection->push((object) $vehicle);
            }
        }

        $baseTransactions->setCollection($resultCollection->unique()->values());

        return $baseTransactions;
    }

    /**
     * Select or unselect the whole page
     *
     * @param $value
     */
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selectedRows = $this->vehicles->pluck('transaction_id')->map(function ($id) {
                return (string)$id;
            });
        } else {
            $this->selectedRows = [];
            $this->selectAll = false;
        }
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
     * Filter toggled
     *
     * @param $filter
     */
    public function filterToggled($filter)
    {
        $this->resetPage();

        $this->filters[$filter['column']] = [
            'column' => $filter['column'],
            'values' => $filter['values'],
            'type' => 'single'
        ];
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
     * Export selected files
     *
     * @param bool $filtered
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function exportSelected($filtered = false)
    {
        $transaction = new Transaction();

        $dataExport = new DataExport($transaction);

        if ($filtered) {
            $query = $this->buildQuery();
        } else {
            if ($this->type === 'seller') {
                $query = Transaction::ofSeller();
            } elseif ($this->type === 'buyer') {
                $query = Transaction::ofBuyer();
            } else {
                $query = Transaction::query();
            }

            if ($this->listType === 'enquiry') {
                $query->whereIn('status', [Transaction::TRANSACTION_STATUS_DENIED, Transaction::TRANSACTION_STATUS_IN_PROGRESS, Transaction::TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION]);
            } elseif ($this->listType === 'order') {
                $query->where('status', '=', Transaction::TRANSACTION_STATUS_APPROVED);
            }
        }

        $collection = $query->get();

        foreach ($collection as &$item) {{
            $item->list_type = $this->type;
        }}

        $filePath = $dataExport->export($collection);

        return Response::download($filePath, $transaction->exportFileName);
    }

    /**
     * Mount per page
     */
    public function mountWithPerPagePagination()
    {
        $this->perPage = session()->get('perPageTransactions', $this->perPage);
    }

    /**
     * Update per page
     *
     * @param $value
     */
    public function updatedPerPage($value)
    {
        session()->put('perPageTransactions', $value);
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
     * Bulk approve selected transactions
     */
    public function approveSelected()
    {
        foreach ($this->selectedRows as $transactionId) {
            $transaction = Transaction::find($transactionId);

            if ($transaction) {
                (new ApproveTransaction())->execute($transaction);
            }
        }
    }

    /**
     * Bulk decline selected transactions
     */
    public function declineSelected()
    {
        foreach ($this->selectedRows as $transactionId) {
            $transaction = Transaction::find($transactionId);

            if ($transaction) {
                (new DenyTransaction())->execute($transaction);
            }
        }
    }
}
