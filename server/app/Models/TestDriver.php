<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestDriver extends Model
{
    /** @use HasFactory<\Database\Factories\TestDriverFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'color',
        'showroom',
        'vehicle_type',
        'location',
        'start_time',
        'end_time',
        'status',
        'description',
        'contact'
    ];

    public function images() {
        return $this->hasMany(Image::class, 'driver_test_id', 'id');
    }

}