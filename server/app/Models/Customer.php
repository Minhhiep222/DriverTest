<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'fullname',
        'phone',
        'address',
        'email',
        'area',
        'age',
        'img',
        'hobbit',
        'income',
        'members',
        'owned',
        'sex',
        'status',
        'type',
    ];
}