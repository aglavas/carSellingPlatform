<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBiddingCredentials extends Model
{
    /**
     * @var string
     */
    protected $table = 'car_bidding_credentials';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
