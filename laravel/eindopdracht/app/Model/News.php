<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    // database aanspreken (inhalen en uithalen en updaten)
    protected $table ='news';
    protected $fillable = [ 
        'profile',
        'title',
        'content',
        'user_id',
    ];
    public function images(){
        return $this->hasMany('App\Model\Image');
    }
}
