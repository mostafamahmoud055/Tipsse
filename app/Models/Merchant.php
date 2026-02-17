<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\BusinessType;
use App\Models\Employee;
use App\Models\MerchantApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'business_type',
        'phone',
        'is_active',
        'user_id',
    ];

    public function getIsActiveAttribute(): string
    {
        return $this->attributes['is_active'] ? 'Active' : 'Inactive';
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Branches()
    {
        return $this->hasMany(Branch::class);
    }
    public function Employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function application()
    {
        return $this->hasOne(MerchantApplication::class);
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

}
