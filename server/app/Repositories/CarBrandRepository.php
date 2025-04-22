<?php

namespace App\Repositories;

use App\Http\Controllers\MailController;
use App\Models\Account;
use App\Models\CarBrand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Mail;
use Request;

class CarBrandRepository
{
    public static function create($name)
    {
        $carBrand = CarBrand::create([
            'name' => $name,
            'user_id' => Auth::id(),
        ]);

        return $carBrand;
    }
}
