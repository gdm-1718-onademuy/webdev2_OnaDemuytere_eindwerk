<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Spotlight extends Model
{
    // 
    protected $table ='spotlight';
    protected $fillable = [
        'product_id',
        'filepath',
        'filename',

    ];
}
