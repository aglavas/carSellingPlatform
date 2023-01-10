<?php

namespace App;

use App\Interfaces\Exportable;
use App\Traits\Cart;
use App\Traits\Export;
use App\Traits\OpenTransactions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class StockMercedes extends Model implements Exportable
{
    use Export, Cart, OpenTransactions;

    protected $table = 'stock_mercedes';

    protected $guarded = ['id'];

    public $exportFileName = 'stock-mercedes.xlsx';

    /**
     * Ident column
     *
     * @var string
     */
    public $identColumn = 'an';

    public $pageTitle = 'Mercedes';

    public $previewTemplate = 'frontend.slideover.vehicle.seller.mercedes';

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
     * @param  string  $value
     * @return void
     */
    public function setVinAttribute($value)
    {
        $this->attributes['vin'] = trim($value);
    }
}
