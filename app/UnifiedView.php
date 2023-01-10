<?php

namespace App;

use App\Interfaces\Exportable;
use App\Traits\Cart;
use App\Traits\Export;
use App\Traits\OpenTransactions;
use Illuminate\Database\Eloquent\Model;

class UnifiedView extends Model implements Exportable
{
    use Cart, OpenTransactions, Export;

    /**
     * @var string
     */
    protected $table = 'unified_view';

    /**
     * Concrete vehicle entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function vehicleEntity()
    {
        $type = new $this->vehicle_type;

        $identColumn = $type->identColumn;

        return $this->morphTo(__FUNCTION__, 'vehicle_type', 'vehicle_ident', $identColumn);
    }

    /**
     * Scope new cars
     *
     * @param $query
     * @return mixed
     */
    public function scopeNewCars($query)
    {
        return $query->whereIn('vehicle_type', [StockOpel::class, StockMercedes::class, StockPeugeotCitroenDs::class, StockFCA::class]);
    }
    
    /**
     * Export additional data
     *
     * @return array|\Illuminate\Support\Collection
     */
    public function exportAdditionalData()
    {
        return [
            'brands' => Brand::get()->keyBy('id'),
            'users' => User::with('brands')->role('Logistics')->get(),
            'usedCarUsers' => User::role('Logistics')
                ->with('company')
                ->orderBy('name', 'ASC')
                ->get()
        ];
    }
}
