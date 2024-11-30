<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Ticket;

class UserTicket extends Model
{
    protected $guarded= ['id'];

    public function event(){
        return $this->belongsTo(Event::class,'event_id');
    }

    public function eventTicket(){
        return $this->belongsTo(EventTicket::class,'ticket_id');
    }
}