<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorService extends Model
{
    protected $table = "doctor_service";

    protected $fillable = [
        'doctor_id', 'service_id','created_at','updated_at'
    ];

    protected $hidden = [
        'created_at','updated_at'
    ];
}
