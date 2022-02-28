<?php

namespace App\Models;

use App\Scopes\OfferScope;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = "Offers";

    protected $fillable = [
        'name_ar', 'name_en', 'price', 'details_ar', 'details_en', 'photo', 'status'
    ];

    protected $hidden = [];

    // public $timestamps = false;

    ######################### local scopes ####################
    public function scopeInactive($query){
        return $query->where('status', 0);
    }

    public function scopeInvalid($query){
        return $query->where('status', 0)->whereNull('details_ar');
    }

    ######################### Global scopes ####################
    //register global scope
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OfferScope);
    }

    ######################### Accessors & Mutators ################################

    public function setNameEnAttribute($value)
    {
        $this->attributes['name_en'] = strtoupper($value);
    }
}
