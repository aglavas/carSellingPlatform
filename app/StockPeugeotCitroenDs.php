<?php

namespace App;

use App\Interfaces\Exportable;
use App\Traits\Cart;
use App\Traits\Export;
use App\Traits\OpenTransactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StockPeugeotCitroenDs extends Model implements Exportable
{
    use Export, Cart, OpenTransactions;

    protected $guarded = ['id'];

    protected $dates = ['ecom'];

    public $exportFileName = 'stock-peugeot-citroen-ds.xlsx';

    /**
     * Ident column
     *
     * @var string
     */
    public $identColumn = 'caf';

    public $pageTitle = 'Peugeot, Citroën, DS';

    public $previewTemplate = 'frontend.slideover.vehicle.seller.pcds';

    /**
     * Returns export additional data
     *
     * @return array
     */
    public function exportAdditionalData()
    {
        return [
            'brands' => Brand::get()->keyBy('id'),
            'users' => User::with('brands')->role('Logistics')->get()
        ];
    }

    /**
     * Stock belongs to many brands
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Format vin before saving
     *
     * @param $value
     */
    public function setVinAttribute($value)
    {
        $this->attributes['vin'] = trim($value);
    }
}
