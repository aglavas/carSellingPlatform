<?php

namespace App;

use App\Interfaces\Exportable;
use App\Traits\Cart;
use App\Traits\Export;
use App\Traits\OpenTransactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StockFCA extends Model implements Exportable
{
    use Export, Cart, OpenTransactions;

    protected $guarded = ['id'];

    protected $table = 'stock_fca';

    /**
     * Ident column
     *
     * @var string
     */
    public $identColumn = 'ident';

    public $exportFileName = 'stock-f-c-as.xlsx';



    public $pageTitle = 'Fiat, Chrysler, Alfa Romeo';

    public $previewTemplate = 'frontend.slideover.vehicle.seller.fca';

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
     * Stock belongs to brand
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Format VIN before saving
     *
     * @param $value
     */
    public function setVinAttribute($value)
    {
        $this->attributes['vin'] = trim($value);
    }
}
