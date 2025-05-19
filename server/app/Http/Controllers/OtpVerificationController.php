<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AuthController;
use App\Models\OtpVerification;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
             
class OtpVerificationController extends Controller
{
    protected $mailController;
    public function __construct(MailController $mailController)
    {
        $this->mailController = $mailController;
    }
    /**
     * Summary of verifyOtp
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        try {
            // Validate OTP
            $validated = $request->validate([
                'phone' => 'required|string',
                'otp' => 'required|string|size:6'
            ]);
            // Kiểm tra OTP
            $otpVerification = OtpVerification::where('phone', $request->phone)
                ->where('is_verified', false)
                ->where('expires_at', '>', now())
                ->latest()
                ->first();
            if (!$otpVerification || now()->isAfter($otpVerification['expires_at'])) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        [
                            'field' => 'otp',
                            'message' => 'Thông tin đăng ký đã hết hạn'
                        ]
                    ]
                ], 400);
            }
            if (!$otpVerification || !Hash::check($request->otp, $otpVerification->otp)) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        [
                            'field' => 'otp',
                            'message' => 'OTP không hợp lệ hoặc đã hết hạn'
                        ]
                    ]
                ], 400);
            }
            // Tạo account mới
            $account = Account::create([
                'phone' => $request['phone'],
                'password' => $otpVerification['password'],
                'role' => 'user',
                'status' => 'Active'
            ]);
            // Tạo user profile
            $user = User::create([
                'account_id' => $account->id,
                'fullname' => $request['phone']
            ]);
            $data = [
                'email' => $account->phone,
                'password' => $otpVerification->password
            ];
            // Gửi email chào mừng
            $this->mailController->sendWelcome($data);
            $loginData = [
                'phone' => $account->phone,
                'password' => $otpVerification->password
            ];
            // Đánh dấu OTP đã được sử dụng
            $otpVerification->update(['is_verified' => true]);
            return $loginData;
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Summary of verifyOTPForgotPassword
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function verifyOTPForgotPassword(Request $request)
    {
        try {
            // Validate OTP
            $validated = $request->validate([
                'phone' => 'required|string',
                'otp' => 'required|string|size:6'
            ]);
            // Kiểm tra OTP
            $otpVerification = OtpVerification::where('phone', $request->phone)
                ->where('is_verified', false)
                ->where('expires_at', '>', now())
                ->latest()
                ->first();
            if (!$otpVerification || now()->isAfter($otpVerification['expires_at'])) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        [
                            'field' => 'otp',
                            'message' => 'Thông tin đăng ký đã hết hạn'
                        ]
                    ]
                ], 400);
            }
            if (!$otpVerification || !Hash::check($request->otp, $otpVerification->otp)) {
                return response()->json([
                    'status' => 'error',
                    'errors' => [
                        [
                            'field' => 'otp',
                            'message' => 'OTP không hợp lệ hoặc đã hết hạn'
                        ]
                    ]
                ], 400);
            }
            // Đánh dấu OTP đã được sử dụng
            $account = Account::where('phone', $request->phone)->first();
            // Generate password
            $password = Str::random(6);
            $data['password'] = $password;
            $data['email'] = $account->phone;
            // Send email
            $this->mailController->sendUser($data);
            // Hash password
            $data['password'] = Hash::make($password);
            $account->password = $data['password'];
            $account->save();
            $otpVerification->update(['is_verified' => true]);
            return response()->json([
                'status' => 'success',
                'message' => 'Xác thực thành công',
                'data' => [
                    'phone' => $request->phone
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
