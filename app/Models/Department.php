<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
    protected $fillable = ['name','contact_number','email', 'created_at'];


public function users()
{
    return $this->belongsToMany(User::class, 'user_department');
}


    public function departments()
{
    return $this->belongsToMany(Department::class, 'user_department');
}
    
}
 