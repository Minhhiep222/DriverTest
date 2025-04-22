<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDriver extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'phone',
        'address',
        'time_drive',
        'date_drive',
        'note',
        'driver_test_id',
        'status',
    ];

    public function books() {
        return $this->belongsTo(TestDriver::class,  'driver_test_id', 'id');
    }
}
