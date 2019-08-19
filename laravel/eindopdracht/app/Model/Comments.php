<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $table ='comment';
    protected $fillable = [ 
        'username',
        'comment',
        'product_id',
        'user_id',
    ];
}
