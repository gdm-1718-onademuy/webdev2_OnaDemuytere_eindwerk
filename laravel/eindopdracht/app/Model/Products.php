<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $table ='products';
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'targetsum',
        'deadline',
        'category_id',
    ];
    public function images(){
        return $this->hasMany('App\Model\Image');
    }
}
