<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketLog extends Model
{
    protected $fillable = [
        'ticket_id', 'user_id', 'action',
        'old_value', 'new_value', 'remarks',
    ];

    public function user()   
    { 
        return $this->belongsTo(User::class); 
    }

    public function ticket() 
    { 
        return $this->belongsTo(Ticket::class); 
    }
}
