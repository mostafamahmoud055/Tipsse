<?php

namespace App\Models;


use App\Models\MerchantApplication;
use App\Models\Payment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'national_id',
        'business_type',
        'phone',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function merchantApplication()
    {
        return $this->hasOne(MerchantApplication::class);
    }

    public function getIsActiveAttribute(): string
    {
        return $this->attributes['is_active'] ? 'Active' : 'Inactive';
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

    public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,
            Employee::class,
            'user_id',
            'employee_id'
        );
    }
}