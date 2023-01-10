<?php

namespace App\Http\Controllers\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Service\DataExport;
use Illuminate\Support\Facades\Response;
use App\Service\EnquiryService;
use App\CartItem;
use App\StockVehicle;

class VehicleBulkActions extends Component
{
    /**
     * @var StockVehicle
     */
    public $resource;

    /**
     * Mount the component
     *
     * @param StockVehicle $stockVehicle
     */
    public function mount(StockVehicle $stockVehicle)
    {
        $this->resource = $stockVehicle;
    }

    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('frontend.livewire.vehicle-bulk-actions');
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

        $collection = $user->bookmarks()->get();

        $filePath = $dataExport->export($collection);

        activity('export_success')
            ->performedOn($this->resource)
            ->withProperties(['rows' => count($collection)])
            ->causedBy($user)
            ->log('Export success.');

        return Response::download($filePath, $this->resource->exportFileName);
    }

    /**
     * Add selected vehicles to cart
     */
    public function addSelectedToCart()
    {
        $user = Auth::user();

        $collection = $user->bookmarks()->get();

        $collection->each(function($vehicle) use ($user) {
            if (EnquiryService::validateEnquiry($vehicle) && !$vehicle->inCart()) {
                CartItem::firstOrCreate(
                    [
                        'vehicle_type' => StockVehicle::class,
                        'user_id' => Auth::user()->id,
                        'vehicle_ident' => $vehicle->manufacturer_id
                    ]
                );

                $user->bookmarks()->detach($vehicle);

                $this->emit('cardCartChange:' . $vehicle->manufacturer_id, $vehicle->manufacturer_id, true);
            }
        });

        $this->emit('cartCountChanged');
        $this->dispatchBrowserEvent('cart-count-changed');
        $this->emit('refreshSelectedCount');
    }
}
