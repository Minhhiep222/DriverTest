<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    // Allow mass assignment for these fields
    public $timestamps = false;
    protected $fillable = ['name', 'user_id'];
}
