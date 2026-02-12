<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchant extends Model
{

    use HasFactory;
    protected $fillable = [
        'name',
        'business_type',
        'email',
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
    public function application()
    {
        return $this->hasOne(MerchantApplication::class);
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }
}
