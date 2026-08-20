<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;


    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'department',
        'branch',
        'clinic',
        'address',
        'role',
        'password',
    ];



    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //assigning users ticket
    public function assignedTickets()
    {
        return $this->belongsToMany(
            Ticket::class,
            'ticket_assigned',
            'user_id',
            'ticket_id'
        );
    }

    //relation to ticket
    public function Ticket()
    {
        return $this->belongsToMany(Ticket::class);
    }

    //relation to department
    public function user_department()
    {
        return $this->belongsToMany(Department::class, 'user_department', 'user_id', 'department_id');
    }

    public function clinic()
{
    return $this->belongsTo(Clinic::class, 'clinics_id');
}

}
