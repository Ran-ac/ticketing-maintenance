<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $table = 'ticket';
    protected $fillable = [

        'type_of_concern',
        'ticket_type',
        'clinics_id',
        'type_equipment_or_machine',
        'equipment_or_machine_brand',
        'serial_number',
        'concern_description',
        'reported_by',
        'email',
        'status',
        'remarks',
        'file',
        'assigned_by'
    ];

     public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinics_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }


    public function assignees()
    {
        return $this->belongsToMany(
            User::class,
            'ticket_assigned',
            'ticket_id',
            'user_id'
        );
    }

    // public function maintenanceAssignees()
    // {
    //     return $this->belongsToMany(User::class, 'ticket_assigned', 'ticket_id', 'user_id')
    //             ->where('users.role', 'maintenance');
    // }
    
}
