<?php

namespace App\Repositories;

use App\Http\Controllers\MailController;
use App\Models\Color;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Mail;
use Request;

class ColorRepository
{
    public static function create($name)
    {
        $cars = Color::create([
            'name' => $name,
            'user_id' => Auth::id(),
        ]);

        return $cars;
    }
}
