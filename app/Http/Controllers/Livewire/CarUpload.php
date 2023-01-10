<?php

namespace App\Http\Controllers\Livewire;

use App\Exceptions\VehicleTypeImportMismatchException;
use App\Exceptions\VehicleTypeListMissing;
use App\Exceptions\VehicleTypeWrongValue;
use App\Imports\StockVehicleImport;
use App\Service\VehicleTypeService;
use App\StockListUpload;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use App\Exceptions\UserVehicleTypeMissing;

class CarUpload extends Component
{
    use WithFileUploads;

    /**
     * @var TemporaryUploadedFile
     */
    public $list;

    /**
     * @var
     */
    public $uploadedList;

    /**
     * @var
     */
    public $warning;

    /**
     * @var
     */
    public $vehicleTypesForDeletion;

    /**
     * @var
     */
    public $company;

    /**
     * @var array
     */
    protected $rules = [
        'list' => 'file|xlsxExtension',
    ];

    /**
     * Submit the file
     *
     * @param bool $skipPreImport
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function submit($skipPreImport = false)
    {
        $this->validate();

        $user = Auth::user();
        
        $filename = $this->list->getClientOriginalName();

        $list = $this->list->storeAs('/', $filename, 'public');

        if (!$skipPreImport || ($user->stock_type == 'UC')) {
            try {
                $result = VehicleTypeService::checkVehicleTypeDeletion(StockVehicleImport::class, $this->list, $user);
            } catch (VehicleTypeListMissing $exception) {
                return redirect()->back()->with('error', 'Vehicle type on list is missing or malformed.');
            } catch (UserVehicleTypeMissing $exception) {
                return redirect()->back()->with('error', 'User does not have vehicle type set on user profile. Please fix this before uploading lists.');
            } catch (VehicleTypeImportMismatchException $exception) {
                return redirect()->back()->with('error', 'User is uploading vehicles with vehicle type that is not configured in it\'s user profile.');
            }  catch (VehicleTypeWrongValue $exception) {
                return redirect()->back()->with('error', 'User has wrong vehicle types in the list. Allowed types are: Passenger, LCV and Truck.');
            }

            if ($result) {
                $this->uploadedList = $list;
                $this->warning = true;
                $this->vehicleTypesForDeletion = $result;
                $this->company = $user->company->name;
                return $this->render();
            }
        }

        $paramArray = [
            'country' => $user->country,
            'file_path' => $list,
            'list_type' =>  StockVehicleImport::class,
            'uploader_id' =>  $user->id,
            'automatic' => false
        ];

        $stockListUpload = StockListUpload::create($paramArray);

        return redirect()->route('car.upload.status', ['upload' => $stockListUpload]);
    }

    /**
     * Upload proceed
     */
    public function uploadProceed()
    {
        $this->submit(true);
    }

    /**
     * Stop upload
     */
    public function stopUpload()
    {
        $this->warning = false;

        $this->render();
    }

    /**
     * Render the component
     *
     * @return mixed
     */
    public function render()
    {
        return view('frontend.livewire.car-upload')->layout('frontend.layouts.app');
    }
}
