<?php

namespace App;

class VehicleParsingObject
{
    /**
     * VehicleParsingObject constructor.
     * @param array $dataRow
     */
    public function __construct(array $dataRow)
    {
        foreach ($dataRow as $key => $value) {
            if ($key) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Empty prop
     *
     * @param $key
     * @return null
     */
    public function __get($key)
    {
        return null;
    }
}
