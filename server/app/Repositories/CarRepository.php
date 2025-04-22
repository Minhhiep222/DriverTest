<?php

namespace App\Repositories;

use App\Http\Controllers\MailController;
use App\Models\Account;
use App\Models\Car;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Mail;
use Request;

class CarRepository
{
    public static function create($name)
    {
        $cars = Car::create([
            'name' => $name,
            'user_id' => Auth::id(),
        ]);

        return $cars;
    }
}
