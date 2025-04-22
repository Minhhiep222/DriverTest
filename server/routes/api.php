<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TestDriverController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\BookDriverController;
use App\Http\Controllers\CapabilitiesController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SettingController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// File routes/api.php
Route::group(['prefix' => 'auth'], function () {
    // Routes công khai
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgotten', [AuthController::class, 'forgotPassword']);
    Route::post('forgot/verify', [AuthController::class, 'verifyOTPForgotPassword']);
    Route::post('register/verify', [AuthController::class, 'verifyOtpAndRegister']);
    Route::post('register/resend-otp', [AuthController::class, 'resendOtp']);

    // Routes yêu cầu xác thực
    Route::middleware('auth:api')->group(function () {
        // Routes chung
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('send-mail', [MailController::class, 'send']);
        Route::get('check-auth', [AuthController::class, 'checkAuth']);
        // Routes cho Admin

        // Route::group(['prefix' => 'admin', 'middleware' => 'check.role:admin'], function() {
        //     Route::get('dashboard', [AdminController::class, 'dashboard']);
        //     Route::get('profile', [AdminController::class, 'profile']);
        // });

        // Routes cho User
        Route::group(['prefix' => 'user', 'middleware' => 'check.role:user'], function () {
            Route::get('dashboard', [UserController::class, 'dashboard']);
            Route::get('profile', [UserController::class, 'profile']);
        });

        // Routes chung cho cả Admin và User
        Route::get('me', [AuthController::class, 'me']);
        Route::put('update', [AuthController::class, 'update']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
    });
});
// Route::middleware(['auth:api'],function(){
// });

Route::middleware(['auth:api'])->group(
    function () {
        Route::apiResource('car-brands', CarBrandController::class);
        Route::get('/user/car-brands', [CarBrandController::class, 'fetchUserCarBrands']);
        Route::get('/user/cars', [CarController::class, 'fetchUserCars']);
        Route::apiResource('/cars', CarController::class);
        Route::get('/user/colors', [ColorController::class, 'fetchUserColors']);
        Route::apiResource('/colors', ColorController::class);
    }
);

Route::middleware(['auth:api', 'check.role:admin', 'check.status:Active'])->group(function () {
    Route::apiResource('users', UserController::class);
});

Route::middleware(['auth:api', 'check.status:Active'])->group(function () {
    Route::apiResource('customers', CustomerController::class);
});

Route::middleware(['auth:api', 'check.status:Active'])->group(function () {
    Route::apiResource('tests', TestDriverController::class);
    Route::get('admin/programs/views', [TestDriverController::class, 'programViews']);
    Route::put('admin/program/confirm/{id}', [TestDriverController::class, 'confirm']);
});

Route::prefix('programs')->group(function () {
    Route::get('views', [TestDriverController::class, 'views']);
    Route::get('deatail/{id}', [TestDriverController::class, 'show']);
});


Route::apiResource('books', BookDriverController::class);

Route::prefix('checks')->group(function () {
    Route::get('/capabilities', [BookDriverController::class, 'check']);
});

Route::apiResource('settings', SettingController::class);
Route::prefix('update/settings')->group(function () {
    Route::put('all', [SettingController::class, 'updateAll']);
});
Route::apiResource('capabilities', CapabilitiesController::class);


Route::get('/images/upload', [ImageController::class, 'create'])->name('images.create');
Route::post('/images', [ImageController::class, 'store'])->name('images.store');
