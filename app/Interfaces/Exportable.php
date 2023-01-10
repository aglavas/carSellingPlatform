<?php

namespace App\Interfaces;

interface Exportable
{
    /**
     * Returns collection with additional data
     *
     * @return \Illuminate\Support\Collection
     */
    public function exportAdditionalData();
}
