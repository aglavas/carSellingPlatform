<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterSearch extends Model
{
    /**
     * @var array
     */
    protected $casts = [
        'filters' => 'json'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'filters',
        'name',
        'vehicle_type'
    ];

    use HasFactory;

    /**
     * Get encoded filters
     *
     * @return mixed
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
