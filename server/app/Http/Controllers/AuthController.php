<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\MeRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Account;
use App\Models\OtpVerification;
use App\Services\SmsService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    protected $smsService;
    protected $otpController;
    protected $otpVerificationController;
    protected $mailController;

    public function __construct(
        SmsService $smsService,
        OTPController $otpController,
        OtpVerificationController $otpVerificationController,
        MailController $mailController
    ) {
        $this->smsService = $smsService;
        $this->otpController = $otpController;
        $this->otpVerificationController = $otpVerificationController;
        $this->mailController = $mailController;
    }

    /**
     * Login user and create token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'phone' => 'required|string',
                'password' => 'required|string|min:6',
            ]);
            // Tìm account với số điện thoại
            $account = Account::where('phone', $request->phone)
                ->where('status', 'Active')
                ->first();
            if (!$account) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        [
                            'field' => 'password',
                            'message' => 'Tài khoản không tồn tại hoặc đã bị khóa',
                        ]
                    ]
                ], 422);
            }
            // Kiểm tra credentials
            if (!Auth::guard('api')->attempt($request->only('phone', 'password'))) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        [
                            'field' => 'password',
                            'message' => 'Số điện thoại hoặc mật khẩu không chính xác',
                        ]
                    ]
                ], 422);
            }
            // Tạo JWT token
            $token = JWTAuth::fromUser($account);

            // Lấy thông tin chi tiết dựa vào role
            $details = null;
            if ($account->role === 'user') {
                $details = User::where('account_id', $account->id)->first();
            } else {
                $details = Admin::where('account_id', $account->id)->first();
            }

            // Chuẩn bị dữ liệu response
            $responseData = [
                'phone' => $account->phone,
                'role' => $account->role,
            ];

            // Thêm thông tin chi tiết theo role
            if ($account->role === 'user') {
                if ($details) {
                    $responseData['name'] = $details->fullname;
                    $responseData['address'] = $details->address;
                }
            } else {
                if ($details) {
                    $responseData['name'] = $details->name;
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Đăng nhập thành công',
                'data' => [
                    'account' => $responseData,
                    'token' => $token,
                    'expiresAt' => config('jwt.ttl') * 60 * 24
                ]
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể tạo token',
            ], 500);
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => $e->getMessage(),
            //     'trace' => config('app.debug') ? $e->getTrace() : []
            // ], 500);
            Log::error('Lỗi: ' . $e->getMessage());
            return response()->json(['message' => 'Có lỗi xảy ra'], 500);
        }
    }

    /**
     * Get authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $user = auth()->user();
            // Lấy thông tin chi tiết dựa vào role
            $name = "User default";

            $details = $user->role === 'user'
                ? User::where('account_id', $user->id)->first()
                : Admin::where('account_id', $user->id)->first();

            $name = $details->fullname ?? $details->name ?? "User default";

            if ($user) {
                $data = [
                    'id' => $user->id,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'status' => $user->status,
                    'name' => $name,
                    'details' => $details
                ];
                return response()->json([
                    'status' => 'success',
                    'data' => $data
                ], 200);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Người dùng không tồn tại'
            ], 404);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    /**
     * Update user information
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            $file = $request->file('image');

            if ($file && $file->isValid()) {
                $path = $file->store('images', 'public');
                // Merge data into request
                $request->merge([
                    'logo' => $path
                ]);
            }

            $user = JWTAuth::parseToken()->authenticate();
            $user = auth()->user();

            if (isset($data['image'])) {
                File::delete(storage_path('app/public/' . $user->logo));
            }

            // Lấy thông tin chi tiết dựa vào role
            $me = $user->role === 'user'
                ? User::where('account_id', $user->id)->first()
                : Admin::where('account_id', $user->id)->first();

            // Kiểm tra xem email có bị trùng không (nếu email được gửi trong request)
            if ($request->has('email') && $request->email != $me->email) {
                $existingUser = User::where('email', $request->email)->where('id', '!=', $me->id)->first();
                if ($existingUser) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => [
                            [
                                'field' => 'email',
                                'message' => 'Email đã tồn tại trong hệ thống, vui lòng sử dụng email khác'
                            ]
                        ]
                    ], 422);
                }
            }

            // Kiểm tra số điện thoại có bị trùng không
            if ($request->has('phone') && $request->phone != $me->phone) {
                $existingPhone = User::where('phone', $request->phone)->where('id', '!=', $me->id)->first();
                if ($existingPhone) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => [
                            [
                                'field' => 'phone',
                                'message' => 'Số điện thoại đã tồn tại trong hệ thống, vui lòng sử dụng số khác'
                            ]
                        ]
                    ], 422);
                }
            }

            // Kiểm tra mã số thuế có bị trùng không
            if ($request->has('tax_code') && $request->tax_code != $me->tax_code) {
                $existingTaxCode = User::where('tax_code', $request->tax_code)->where('id', '!=', $me->id)->first();
                if ($existingTaxCode) {
                    return response()->json([
                        'status' => 'error',
                        'errors' => [
                            [
                                'field' => 'tax_code',
                                'message' => 'Mã số thuế đã tồn tại trong hệ thống, vui lòng kiểm tra lại'
                            ]
                        ]
                    ], 422);
                }
            }
            $me->update($request->all());
            $data = [
                'name' => $me->fullname
            ];

            if ($user) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Cập nhật thông tin thành công',
                    'data' => $data
                ], 200);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Người dùng không tồn tại'
            ], 404);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi cơ sở dữ liệu: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout user (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'status' => 'success',
                'message' => 'Đăng xuất thành công'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to logout'
            ], 500);
        }
    }

    /**
     * Refresh a token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'status' => 'success',
                'data' => [
                    'token' => $token,
                    'expiresAt' => now()->addMinutes(5)
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not refresh token'
            ], 500);
        }
    }

    /**
     * Register a new user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRequest $request)
    {
        try {
            // Validate đầu vào
            $validated = $request->validate([
                'phone' => 'required|string|unique:accounts',
                'password' => 'required|string|min:6',
            ]);

            // Tạo mã OTP ngẫu nhiên 6 số
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Lưu OTP vào database với thời hạn 5 phút
            OtpVerification::create([
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'otp' => Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
            ]);

            try {
                $data = [
                    'phone' => $request->phone,
                    'otp' => $otp
                ];

                // Kiểm tra nếu đầu vào là số điện thoại thì gửi OTP qua SMS
                if (filter_var($request->phone, FILTER_VALIDATE_EMAIL)) {
                    // Gửi OTP qua email
                    $this->mailController->sendOtp($data);
                } else {
                    // Gửi OTP qua SMS
                    $otp = $this->smsService->sendOtp($request->phone, $otp);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        [
                            'field' => 'password',
                            'message' => 'Không thể gửi OTP. Vui lòng thử lại sau.'
                        ]
                    ]
                ], 500);
            }


            return response()->json([
                'status' => 'success',
                'message' => 'OTP đã được gửi đến điện thoại của bạn',
                'data' => [
                    'phone' => $request->phone,
                    'expires_in' => 300
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Summary of verifyOtpAndRegister
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function verifyOtpAndRegister(Request $request)
    {
        $verify = $this->otpVerificationController->verifyOtp($request);
        if ($verify) {
            $auth = $this->login($request);
        }
        return $auth;
    }

    /**
     * Summary of resendOtp
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function resendOtp(Request $request)
    {
        return $this->otpController->resendOTP($request);
    }


    /*
        * Summary of forgotPassword
        * @param \Illuminate\Http\Request $request
        * @return mixed|\Illuminate\Http\JsonResponse
        */
    public function forgotPassword(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'phone' => 'required',
            ]);

            $account = Account::where('phone', $request->phone)->first();

            if (!$account) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Tài khoản không tồn tại'
                ], 404);
            }

            // Generate a random 6-digit OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Save OTP to database with a 5-minute expiration
            OtpVerification::create([
                'phone' => $request->phone,
                'password' => $request->phone,
                'otp' => Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
            ]);


            // Prepare data for email
            $data = [
                'phone' => $request->phone,
                'otp' => $otp
            ];

            // Send OTP via phone
            $this->mailController->sendOtp($data);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP đã được gửi đến điện thoại của bạn',
                'data' => [
                    'phone' => $request->phone,
                    'expires_in' => 300
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to send OTP. Please try again later.'
            ], 500);
        }
    }


    public function verifyOTPForgotPassword(Request $request)
    {
        return $this->otpVerificationController->verifyOtpForgotPassword($request);
    }

    /**
     * Summary of checkAuth
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function checkAuth()
    {
        try {
            $user = auth()->user();
            if ($user) {
                $data = [
                    'id' => $user->id,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'status' => $user->status,
                ];
                return response()->json([
                    'status' => 'success',
                    'message' => 'Đã đăng nhập',
                    'data' => [
                        'user' => $data
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Chưa đăng nhập'
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }
}
