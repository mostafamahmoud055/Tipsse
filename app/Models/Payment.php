<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'payment_method',
        'status',
        'amount',
        'reference_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
