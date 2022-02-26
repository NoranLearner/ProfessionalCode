<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = "services";

    protected $fillable = [
        'name', 'created_at','updated_at'
    ];

    protected $hidden = [
        'created_at','updated_at','pivot'
    ];

    ################## Begin many to many relationship ############
    public function doctors(){
        return $this -> belongsToMany('App\Models\Doctor','doctor_service','service_id','doctor_id','id','id');
    }
}
