<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantApplication extends Model
{
        protected $fillable = [
        'merchant_id',
        'user_id',
        'application_number',
        'status',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
