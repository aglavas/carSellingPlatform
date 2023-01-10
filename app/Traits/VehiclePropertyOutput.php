<?php

namespace App\Traits;

trait VehiclePropertyOutput {

    /**
     * Get vehicle property for displaying
     *
     * @param string $key
     * @return mixed|string
     */
    public function getPropertyForDisplaying(string $key)
    {
        if (!$this->$key) {
            return '';
        }

        if ($key === 'firstregistration') {
            return $this->getFirstRegistrationString();
        }

        return ucfirst($this->$key);
    }

    /**
     * Get first registration string
     *
     * @return mixed
     */
    public function getFirstRegistrationString()
    {
        return $this->firstregistration->format('Y-m-d');
    }
}
