<?php

namespace App\Http\Controllers;

use App\Models\Capabilities;
use Illuminate\Http\Request;

class CapabilitiesController extends Controller
{

    public function index()
    {

        try {

            $data = Capabilities::first();

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

    /**
     * Handle update capa
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function update(Request $request, $id)
    {
        try {
            $capa = Capabilities::find($id);
            if (isset($request->quantity)) {
                $capa->quantity = $request->quantity;
            }
            if (isset($request->status)) {
                $capa->status = $request->status;
            }
            $capa->save();
            return response()->json([
                'message' => "Cập nhật thành công",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Handle create capa
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            $capa = new Capabilities();
            $capa->quantity = $request->quantity;
            $capa->status = $request->status;
            $capa->save();
            return response()->json([
                'message' => "Tạo mới thành công",
                'data' => $capa
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show capa by test_driver_id
     * @param int $test_driver_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($test_driver_id)
    {
        try {
            $data = Capabilities::where('test_driver_id', $test_driver_id)->first();
            if ($data) {
                return response()->json([
                    'success' => true,
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
