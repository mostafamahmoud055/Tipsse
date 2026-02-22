<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'user_id',
        'payment_method',
        'status',
        'amount',
        'transaction_id',
        'rating',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function merchant()
    {
        return $this->belongsTo(User::class);
    }
}
