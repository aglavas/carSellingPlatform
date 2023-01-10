<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VinDocuments extends Model
{
    /**
     * @var string
     */
    protected $table = 'vin_documents';

    /**
     * @var array
     */
    protected $fillable = [
        'vin',
        'description1',
        'path1',
        'description2',
        'path2',
        'description3',
        'path3',
        'description4',
        'path4',
        'description5',
        'path5',
        'description6',
        'path6',
        'description7',
        'path7',
        'description8',
        'path8',
        'description9',
        'path9',
        'description10',
        'path10',
    ];
}
