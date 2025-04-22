<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtpVerification;
use App\Services\SmsService;

use Illuminate\Support\Facades\Hash;

class OTPController extends Controller
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Handle resend OTP
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function resendOTP(Request $request)
    {

        try {

            $validated = $request->validate([
                'phone' => 'required|string'
            ]);

            $lastOtp = OtpVerification::where('phone', $request->phone)
                ->where('created_at', '>', now()->subMinute())
                ->first();

            if ($lastOtp) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vui lòng đợi 1 phút trước khi gửi lại OTP',
                    'wait_time' => 60 - now()->diffInSeconds($lastOtp->created_at)
                ], 400);
            }

            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Lưu OTP vào database với thời hạn 5 phút
            OtpVerification::create([
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'otp' => Hash::make($otp),
                'expires_at' => now()->addMinutes(5),
            ]);

            // Gửi otp
            $this->smsService->sendOtp($request->phone, $otp);

            return response()->json([
                'status' => 'success',
                'message' => 'Đã gửi lại OTP',
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
}
