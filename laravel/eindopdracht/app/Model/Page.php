<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // hierin spreek je tabel aan uit de db 
    protected $table = 'pages';
    protected $fillable = [
        'name',
        'content',
    ]; // in deze array komen de invulbare veldjes van de pages tabel
}
