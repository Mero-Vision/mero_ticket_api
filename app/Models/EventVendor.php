<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventVendor extends Model
{
    protected $guarded= ['id'];

    public function vendorUser(){
        return $this->belongsTo(User::class,'vendor_user_id');
    }

    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }
}