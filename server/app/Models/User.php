<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'logo',
        'phone',
        'fullname',
        'shortname',
        'email',
        'MST',
        'address',
        'website',
        'description'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
