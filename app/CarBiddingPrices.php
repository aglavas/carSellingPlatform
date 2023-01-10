<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBiddingPrices extends Model
{
    /**
     * @var string
     */
    protected $table = 'car_bidding_prices';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
