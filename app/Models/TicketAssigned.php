<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAssigned extends Model
{
    protected $table = 'ticket_assigned';

    protected $fillable = [
        'ticket_id',
        'user_id',
        'assigned_at'
    ];

    protected $casts = [
        'assigned_at' => 'datetime'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
