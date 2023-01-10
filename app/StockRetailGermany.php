<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockRetailGermany extends Model
{

    protected $table = 'stock_retail';

    protected $guarded = ['id'];

    protected $casts = [
        'is_metallic' => 'boolean',
        'has_warranty' => 'boolean',
        'equipment' => 'array',
        'net_price_including_vat' => 'boolean',
        'properties' => 'array',
        'additional_properties' => 'array',
        'standard_equipment' => 'array',
        'optional_equipment' => 'array'
    ];

    protected $dates = ['in_stock_since'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
