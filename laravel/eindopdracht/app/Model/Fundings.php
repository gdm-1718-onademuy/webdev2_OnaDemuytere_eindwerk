<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Fundings extends Model
{
    //
    protected $table ='fund';
    protected $fillable = [ 
        'username',
        'amount',
        'product_id',
        'user_id',
    ];
}
