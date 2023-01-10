<?php

namespace App;

use App\Interfaces\Exportable;
use App\Traits\Cart;
use App\Traits\Export;
use App\Traits\OpenTransactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


class StockOpel extends Model implements Exportable
{
    use Export, Cart, OpenTransactions;

    protected $table = 'stock_opel';

    protected $guarded = ['id'];

    protected $dates = ['transaction_date'];

    public $exportFileName = 'stock-opels.xlsx';

    /**
     * Ident column
     *
     * @var string
     */
    public $identColumn = 'caf';

    public $pageTitle = 'Opel';

    public $previewTemplate = 'frontend.slideover.vehicle.seller.opel';

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
     * Stock belongs to brand
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
