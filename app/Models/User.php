<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'image',
        'phone',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Một người sẽ có nhiều VourcherUsage
    public function voucherUsages()
    {
        return $this->hasMany(VoucherUsage::class);
    }
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'user_roles');
    // }
    public function addressUsers()
    {
        return $this->hasMany(AddressUser::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
