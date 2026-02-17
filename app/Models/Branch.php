<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'is_active',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }


    public function getIsActiveAttribute(): string
    {
        return $this->attributes['is_active'] ? 'Active' : 'Inactive';
    }
}
