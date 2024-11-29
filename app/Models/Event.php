<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded= ['id'];

    public function eventVendors(){
        return $this->hasMany(EventVendor::class,'event_id');
    }
}