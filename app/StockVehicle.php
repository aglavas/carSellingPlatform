<?php

namespace App;

use App\Export\StockVehicleExport;
use App\Interfaces\Exportable;
use App\Service\CarBidding\BiddingUpdater;
use App\Traits\Cart;
use App\Traits\Export;
use App\Traits\OpenTransactions;
use App\Traits\VehiclePropertyOutput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StockVehicle extends Model implements Exportable
{
    const STATUS_SYNC_SUCCESS = 'sync_success';
    const STATUS_SYNC_COMPLETED = 'sync_completed';
    const STATUS_SYNC_ERROR = 'sync_error';
    const STATUS_SYNC_DONT_SYNC = 'sync_dont_sync';
    const USED_CARS = 'used';
    const NEW_CARS = 'new';

    /**
     * Columns for NL (xml) and DE (csv) import
     */
    const HEADER_COLUMNS = [
        'manufacturer_id',
        'origin',
        'brand',
        'model',
        'version_code',
        'version_description',
        'kw',
        'cm3',
        'hp',
        'fuel_type',
        'gearbox',
        'km',
        'firstregistration',
        'interior',
        'color_code',
        'color_description',
        'options_code',
        'option_code_description',
        'co2',
        'b2b_price_ex_vat',
        'vat_deductible',
        'damages_excl_vat_info',
        'disponsibility',
        'loading_place',
        'note',
        'language_option_code_description',
        'currency_iso_codification',
        'url_address',
        'media_path',
        'account_id',
        'body_type',
        'sku_number',
        'certification_code',
        'condition_type',
        'fuel_consumption_city',
        'fuel_consumption_land',
        'fuel_consumption_rating',
        'fuel_consumption_total',
        'cylinders',
        'coc',
        'documents',
        'doors',
        'drive_type',
        'has_warranty',
        'id',
        'model_group',
        'pollution_norm',
        'price',
        'price_history',
        'price_new',
        'properties',
        'additional_properties',
        'seats',
        'segmentation_id',
        'teaser',
        'videos',
        'weight',
        'vehicle_type',
    ];

    use HasFactory, Cart, OpenTransactions, Export, VehiclePropertyOutput;

    protected $guarded = ['id'];

    protected $dates = ['firstregistration', 'disponibility'];

    protected $table = 'stock_vehicles';

    public $casts = [
        'external_id' => 'json',
        'properties' => 'json',
        'additional_properties' => 'json',
    ];

    /**
     * Ident column
     *
     * @var string
     */
    public $identColumn = 'manufacturer_id';

    protected $primaryKey = 'manufacturer_id';

    protected $keyType = 'string';
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'manufacturer_id';
    }

    /**
     * @var string
     */
    public $exportFileName = 'stock-vehicle.xlsx';

    /**
     * @var string
     */
    public $exportClass = StockVehicleExport::class;

    public $pageTitle = 'All vehicles';

    public $previewTemplate = 'frontend.slideover.vehicle.seller.used-cars';


    /////////////////////////Relations/////////////////////////////////////////////////

    /**
     * Vehicle has one settings field
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings()
    {
        return $this->hasOne(StockVehicleSettings::class, 'manufacturer_id', 'manufacturer_id');
    }

    /**
     * Vehicle has many bidding prices
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function biddingPrices()
    {
        return $this->hasOne(CarBiddingPrices::class, 'manufacturer_id', 'manufacturer_id');
    }

    /**
     * Vehicle can morph to many cart items
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function carts()
    {
        return $this->morphMany(CartItem::class, 'vehicle');
    }

    /**
     * Vehicle can have one cart data
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cartData()
    {
        $user = Auth::user();

        return $this->hasOne(CartItem::class, 'vehicle_ident', 'manufacturer_id')->where('cart_items.user_id', $user->id);
    }

    /**
     * Vehicle can have one cart data
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function enquiryData()
    {
        $user = Auth::user();

        return $this->hasOne(Transaction::class, 'vehicle_ident', 'manufacturer_id')->where('transactions.buyer_id', $user->id)->where(
            'status',
            Transaction::TRANSACTION_STATUS_IN_PROGRESS
        );
    }

    /**
     * Vehicle can have one cart data
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function deniedEnquiryData()
    {
        $user = Auth::user();

        return $this->hasOne(Transaction::class, 'vehicle_ident', 'manufacturer_id')->where('transactions.buyer_id', $user->id)->where(
            'status',
            Transaction::TRANSACTION_STATUS_DENIED
        );
    }

    /**
     * Vehicle belongs to a company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ownerCompany()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * Vehicle belongs to many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookmarks()
    {
        $user = Auth::user();

        return $this->belongsToMany(User::class, 'user_vehicle_selected_pivot_table',  'manufacturer_id','user_id')->where(['user_vehicle_selected_pivot_table.user_id' => $user->id]);
    }

    ///////////////////////////////////////////////////////////////////////////////////

    /////////////////////////Methods///////////////////////////////////////////////////

    /**
     * Check if vehicle bookmarked
     *
     * @return bool
     */
    public function isBookmarked()
    {
        if (!$this->relationLoaded('bookmarks')) {
            return false;
        }

        if (count($this->bookmarks)) {
            return true;
        }

        return false;
    }

    /**
     * Get seller contacts
     *
     * @return mixed
     */
    public function sellerContacts()
    {
        $country = $this->country;
        $companyId = $this->company_id;
        $vehicleType = $this->vehicle_type;
        $brand = strtoupper(trim($this->brand));
        $conditionType = $this->condition_type;

        if ($conditionType === 'used') {
            $contactCollection = \App\User::role('Logistics')
                ->where('country', 'ilike', strtoupper($country))
                ->where('company_id', $companyId)
                ->where(function ($query) {
                    $query->where('stock_type', 'UC')
                        ->orWhere('stock_type', 'both');
                })
                ->orderBy('name', 'ASC')
                ->get();
        } else {
            $contactCollection = \App\User::role('Logistics')
                ->where('country', 'ilike', strtoupper($country))
                ->where('company_id', $companyId)
                ->where(function ($query) {
                    $query->where('stock_type', 'NC')
                        ->orWhere('stock_type', 'both');
                })
                ->whereRaw("(vehicle_type)::jsonb ?? '$vehicleType'")
                ->whereHas('brands', function ($query) use ($brand) {
                    $query->where('name', $brand);
                })
                ->orderBy('name', 'ASC')
                ->get();
        }

        return $contactCollection;
    }

    /**
     * Set vehicle status as reserved
     *
     * @return bool
     */
    public function reserveVehicle()
    {
        $this->addToSettings([
           'enquiry_status' => Transaction::VEHICLE_STATUS_RESERVED
        ]);

        return true;
    }

    /**
     * Returns export additional data
     *
     * @return array
     */
    public function exportAdditionalData()
    {
        return User::role('Logistics')
            ->with('company')
            ->orderBy('name', 'ASC')
            ->get();
    }

    /**
     * Add data to settings table
     *
     * @param array $data
     * @return bool
     */
    public function addToSettings(array $data)
    {
        if (!$this->relationLoaded('settings')) {
            $this->load('settings');
        }

        if (!$this->settings) {
            $this->settings()->create($data);
        } else {
            $this->settings()->update($data);
        }

        return true;
    }

    /**
     * Get from settings if exists
     *
     * @param string $key
     * @return mixed|null
     */
    public function getFromSettings(string $key)
    {
        if (!$this->relationLoaded('settings')) {
            $this->load('settings');
        }

        if (!$this->settings) {
            return null;
        }

        /** @var StockVehicleSettings $settings */
        $settings = $this->settings;

        $settingsValue = $settings->getAttribute($key);

        if (!$settingsValue) {
            return null;
        }

        return $settingsValue;
    }

    /**
     * Get banner image
     *
     * @return string|null
     */
    public function getBannerImage()
    {
        $mediaPathArray = explode(';', $this->media_path);

        if (!count($mediaPathArray)) {
            return null;
        }

        $bannerImageUrl = $mediaPathArray[0];

        $companyId = $this->company_id;

        $company = Company::find($companyId);

        try {
            if (in_array($company->id, [86, 87, 88])) {
                $path = null;

                $mappingArray = config('carmarket.imports.used.nl.mappings');

                $mappingKeys = array_keys($mappingArray);

                foreach ($mappingKeys as $key) {
                    $companyId = $mappingArray[$key]['klantnummer'];

                    if ($companyId == $company->id) {
                        $path = asset("nl_images/{$key}/images/{$bannerImageUrl}");
                        break;
                    }
                }

                return $path;
            } elseif ($company->id === 106) {
                $path = asset("de_images/{$bannerImageUrl}");

                return $path;
            }
        } catch (\Exception $exception) {
            return null;
        }


        if (filter_var($bannerImageUrl, FILTER_VALIDATE_URL)) {
            return $bannerImageUrl;
        }

        return null;
    }

    /**
     * Get vehicle documents
     *
     * @return array
     */
    public function getDocuments()
    {
        $documents = $this->documents;

        $documentArray = explode(';', $documents);

        if (count($documentArray)) {
            array_pop($documentArray);

            return $documentArray;
        }

        return [];
    }

    /**
     * Get owner company
     */
    public function getCompanyObject()
    {
        $this->load('ownerCompany');

        return $this->ownerCompany;
    }

    ///////////////////////////////////////////////////////////////////////////////////


    /////////////////////////Scopes///////////////////////////////////////////////////

    /**
     * Without reserved
     *
     * @param $query
     * @return mixed
     */
    public function scopeWithoutReserved($query)
    {
        $query->whereHas('settings', function ($q) {
            $q->where('enquiry_status', 'is distinct from', \App\Transaction::VEHICLE_STATUS_RESERVED);
        })->orWhereDoesntHave('settings');

        return $query;
    }

    ///////////////////////////////////////////////////////////////////////////////////

    /////////////////////////Accessors/////////////////////////////////////////////////

    /**
     * First year registration accessor
     *
     * @return string
     */
    public function getFirstRegistrationYearAttribute()
    {
        return is_null($this->firstregistration) ? '' : $this->firstregistration->format('Y');
    }

    /**
     * First year and month registration accessor
     *
     * @return string
     */
    public function getFirstRegistrationYearMonthAttribute()
    {
        return is_null($this->firstregistration) ? '' : $this->firstregistration->format('m.Y');
    }

    ///////////////////////////////////////////////////////////////////////////////////

    /////////////////////////Checks/////////////////////////////////////////////////

    /**
     * Is Vat deductible
     *
     * @return bool
     */
    public function isVatDeductible()
    {
        if ($this->vat_deductible) {
            return true;
        }

        return false;
    }

    /**
     * Has Coc document
     *
     * @return bool
     */
    public function hasCoc()
    {
        if ($this->coc) {
            return true;
        }

        return false;
    }

    /**
     * Has disponsibility
     *
     * @return bool
     */
    public function hasDisponsibility()
    {
        if ($this->disponsibility) {
            return true;
        }

        return false;
    }

    /**
     * Check if vehicle has non euro price
     *
     * @return bool
     */
    public function hasNonEuroPrice()
    {
        if ($this->currency_iso_codification === 'EUR') {
            return false;
        }

        return true;
    }

    ///////////////////////////////////////////////////////////////////////////////////

    /**
     * Boot override
     */
    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            BiddingUpdater::vehicleChanged($model);
        });

        self::updated(function($model){
            BiddingUpdater::vehicleChanged($model);
        });
    }
}
