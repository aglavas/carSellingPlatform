<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = ['id'];

    /**
     * Name attribute mutator
     *
     * @param $name
     */
    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtoupper(trim($name));
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function peugeotCitroenDsVehicles()
    {
        return $this->hasMany(StockPeugeotCitroenDs::class);
    }

    public function opelVehicles()
    {
        return $this->hasMany(StockOpel::class);
    }

    public function mercedesVehicles()
    {
        return $this->hasMany(StockMercedes::class);
    }
}
