<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'national_id', 'merchant_id', 'branch_id', 'is_active'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
