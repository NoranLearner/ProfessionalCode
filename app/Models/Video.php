<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = "Videos";

    protected $fillable = [
        'name', 'viewers'
    ];

    protected $hidden = [];

}
