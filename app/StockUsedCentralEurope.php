<?php

namespace App;

use App\Interfaces\Exportable;
use App\Traits\Cart;
use App\Traits\Export;
use App\Traits\OpenTransactions;
use Illuminate\Database\Eloquent\Model;

class StockUsedCentralEurope extends Model implements Exportable
{
    use Export, Cart, OpenTransactions;

    protected $table = 'stock_retail_central_europe';

    protected $guarded = ['id'];

    protected $dates = ['firstregistration', 'disponibility'];

    protected $casts = [
      'price_in_euro' => 'integer'
    ];

    /**
     * Ident column
     *
     * @var string
     */
    public $identColumn = 'vin';

    public $exportFileName = 'stock-used-central-europes.xlsx';

    public $pageTitle = 'Used cars';

    public $previewTemplate = 'frontend.slideover.vehicle.seller.used-cars';

    /**
     * Return additional data collection
     *
     * @return mixed
     */
    public function exportAdditionalData()
    {
        return User::role('Logistics')
            ->with('company')
            ->where('stock_type', 'UC')
            ->orderBy('name', 'ASC')
            ->get();
    }

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
     * Get image attribute accessor
     *
     * @return array
     */
    public function getImageAttribute()
    {
        $mediaPathArray = explode(';', $this->media_path);

        if (!count($mediaPathArray)) {
            return [];
        }

        $companyName = $this->company;

        $company = Company::where('name', $companyName)->first();

        $mappingArray = config('carmarket.imports.used.nl.mappings');

        $mappingKeys = array_keys($mappingArray);

        $pathArray = [];

        foreach ($mappingKeys as $key) {
            $companyId = $mappingArray[$key]['klantnummer'];

            if ($companyId == $company->id) {
                foreach ($mediaPathArray as $image) {
                    $path = asset("nl_images/{$key}/images/{$image}");

                    array_push($pathArray, $path);
                }
                break;
            }
        }

        return $pathArray;
    }

    /**
     * Format VIN before saving
     *
     * @param  string  $value
     * @return void
     */
    public function setVinAttribute($value)
    {
        $this->attributes['vin'] = trim($value);
    }

    /**
     * Boot override
     */
    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            //VinHistoryService::createUsedCarsVinHistory($model);
        });
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
     * One VIN can have multiple documents
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vinDocuments()
    {
        return $this->hasOne(VinDocuments::class, 'vin', 'vin');
    }

    /**
     * Get VIN documents
     *
     * @return mixed
     */
    public function getVinDocuments()
    {
        $this->load('vinDocuments');

        $vinDocuments = $this->vinDocuments;

        return $vinDocuments;
    }
}
