<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\WelcomeUser;
use App\Mail\WelcomeCustomer;
use App\Mail\WelcomeMail;
use App\Mail\SendOTP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function sendOtp(array $data)
    {
        try {
            Mail::to($data['phone'])->send(new SendOTP($data));

            return response()->json([
                'success' => true,
                'message' => 'Email đã được gửi thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi gửi email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendWelcome(array $data)
    {
        try {
            Mail::to($data['email'])->send(new WelcomeMail($data));

            return response()->json([
                'success' => true,
                'message' => 'Email đã được gửi thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi gửi email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendUser(array $data)
    {
        try {
            Mail::to($data['email'])->send(new WelcomeUser($data));

            return response()->json([
                'success' => true,
                'message' => 'Email đã được gửi thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi gửi email: ' . $e->getMessage()
            ], 500);
        }
    }
    public function sendCustomer(array $data, $showroom)
    {
        try {
            Mail::to($data['email'])->send(new WelcomeCustomer($data, $showroom));

            return response()->json([
                'success' => true,
                'message' => 'Email đã được gửi thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi gửi email: ' . $e->getMessage()
            ], 500);
        }
    }
}
