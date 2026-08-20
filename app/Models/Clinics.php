<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinics extends Model
{

    protected $table = 'clinics';
    protected $fillable = ['name','company','contact_number','email','address', 'created_at'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'clinics_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
