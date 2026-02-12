<?php

namespace App\Models;

use App\Models\User;
use App\Models\MerchantApplication;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'merchant_id',
        'name',
        'is_active',
        'image'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }


    public function getIsActiveAttribute(): string
    {
        return $this->attributes['is_active'] ? 'Active' : 'Inactive';
    }
}
