<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'password',
        'role',
        'status'
    ];

    protected $hidden = [
        'password',
        'phone',
        'id',
        'role'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}