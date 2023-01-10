<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @Deprecated
 *
 * Class WishlistItems
 * @package App
 */
class WishlistItems extends Model
{
    /**
     * @var string
     */
    protected $table = 'wishlist_items';

    /**
     * @var array
     */
    protected $fillable = ['vehicle_ident', 'user_id', 'vehicle_type'];

    /**
     * Return vehicle database id
     *
     * @return mixed
     * @throws \Exception
     */
    public function getVehicleIdAttribute()
    {
        $vehicle = $this->getVehicle();

        return $vehicle->id;
    }

    /**
     * Return vehicle database id
     *
     * @return mixed
     * @throws \Exception
     */
    public function getStatusAttribute()
    {
        $vehicle = $this->getVehicle();

        return $vehicle->enquiry_status;
    }

    /**
     * Morph to vehicle
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function vehicle()
    {
        $type = new $this->vehicle_type;

        $identColumn = $type->identColumn;

        return $this->morphTo(__FUNCTION__, 'vehicle_type', 'vehicle_ident', $identColumn);
    }

    /**
     * Get vehicle
     *
     * @return mixed
     * @throws \Exception
     */
    private function getVehicle()
    {
        /** @var Model $model */

        $model = new $this->vehicle_type;

        $identColumn = $model->identColumn;

        $vehicle = $model->where($identColumn, $this->vehicle_ident)->first();

        if (!$vehicle) {
            throw new \Exception('There is no vehicle with that ID.');
        }

        return $vehicle;
    }
}
