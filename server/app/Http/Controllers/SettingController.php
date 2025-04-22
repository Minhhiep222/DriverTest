<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {

        try {

            $data = Setting::all();

            return response()->json([
                'sucsess' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'sucsess' => false,
                'errors' => $e->getMessage()
            ], 500);
        }
    }
    //
    public function updateAll(Request $request)
    {
        try {

            foreach ($request->all() as $item) {
                $setting = Setting::find($item['id']);
                if (isset($item['end'])) {
                    $setting->end = $item['end'];
                }
                if (isset($item['start'])) {
                    $setting->start = $item['start'];
                }
                if (isset($item['status'])) {
                    $setting->status = $item['status'];
                }
                $setting->save();
            }

            return response()->json([
                'message' => 'Cập nhật thành công!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($test_driver_id)
    {
        try {
            $data = Setting::where('test_driver_id', $test_driver_id)->get();

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tồn tại phần cài đặt nào'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
