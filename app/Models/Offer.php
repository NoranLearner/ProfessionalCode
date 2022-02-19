<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = "Offers";

    protected $fillable = [
        'name_ar', 'name_en', 'price', 'details_ar', 'details_en', 'photo'
    ];

    protected $hidden = [];

    // public $timestamps = false;

}
