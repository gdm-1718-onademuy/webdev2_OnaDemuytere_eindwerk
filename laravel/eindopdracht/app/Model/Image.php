<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $table ='images';
    protected $fillable = [ 
        'filepath',
        'filename',
        'product_id',
        'user_id',
        'news_id',

    ];
    public function product(){
        return $this->hasOne('App\Model\Products');
    }
}
