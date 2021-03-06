<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = ["apartment_id", "ip_address"];

    public function apartment(){
        return $this->belongsTo('App\Models\Apartment');
    }
}
