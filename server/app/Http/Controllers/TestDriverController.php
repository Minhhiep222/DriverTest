<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\DriverTestRequest;
use App\Repositories\DriverTestRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\Capabilities;

class TestDriverController extends Controller
{
    protected $driverTestRepository;
    protected $imageUploadRequest;
    protected $imageController;

    public function __construct(DriverTestRepository $driverTestRepository, ImageController $imageController)
    {
        $this->driverTestRepository = $driverTestRepository;
        $this->imageController = $imageController;
    }

    /**
     * Handle get all program
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function views(Request $request)
    {
        try {

            $filters = $request->only([
                'search',
                'name',
                'location',
                'start_time',
                'end_time',
                'vehicle_type',
                'status',
                'type',
                'page',
                'sort_by',
                'sort_direction',
                'per_page'
            ]);

            $diverTestData = $this->driverTestRepository->getAll($filters);

            $diverTests = $diverTestData['data'];


            return response()->json([
                'success' => true,
                'message' => 'Lấy chương trình lái thử thành công',
                'data' => $diverTests,
                'totalRecord' => $diverTestData['total']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function programViews(Request $request)
    {
        try {

            $filters = $request->only([
                'search',
                'name',
                'location',
                'start_time',
                'end_time',
                'vehicle_type',
                'status',
                'type',
                'page',
                'sort_by',
                'sort_direction',
                'per_page'
            ]);

            $diverTestData = $this->driverTestRepository->getByAdmin($filters);

            $diverTests = $diverTestData['data'];


            return response()->json([
                'success' => true,
                'message' => 'Lấy chương trình lái thử thành công',
                'data' => $diverTests,
                'totalRecord' => $diverTestData['total']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle get program by user
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {

            $filters = $request->only([
                'search',
                'name',
                'location',
                'start_time',
                'end_time',
                'vehicle_type',
                'status',
                'type',
                'page',
                'sort_by',
                'sort_direction',
                'per_page'
            ]);

            $diverTestData = $this->driverTestRepository->getByUser($filters);

            $diverTests = $diverTestData['data'];


            return response()->json([
                'success' => true,
                'message' => 'Lấy chương trình lái thử thành công',
                'data' => $diverTests,
                'totalRecord' => $diverTestData['total']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle get the driver test by id
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $diverTest = $this->driverTestRepository->findByIdWithImage($id);

            if (!$diverTest) {
                return response()->json([
                    'success' => false,
                    'message' => "Không có chương trình lái thử trong dữ liệu",
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => "Lấy chương trình lái thử thành công",
                'data' => $diverTest
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy chương trình lái thử trong hệ thống"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Handle create the driver test
     * @param \App\Http\Requests\DriverTestRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(DriverTestRequest $request)
    {
        try {
            DB::beginTransaction();
            $user_id = auth()->user()->id;

            $settings = $request->input('settings');

            $settingsData = json_decode($settings);


            // Extention data to create the driver test
            $request->merge([
                'user_id' => $user_id,
            ],);

            $request['start_time'] = $settingsData[0]->date;

            // Trích xuất mảng các ngày từ $settingsData
            $dates = array_column($settingsData, 'date');

            // Tìm ngày lớn nhất trong mảng
            $request['end_time'] = max($dates);


            $diverTest = $this->driverTestRepository->create($request->all());

            // Extention data to create the image
            $request->merge(['driver_test_id' => $diverTest->id]);

            $this->imageController->upload(new ImageUploadRequest($request->all()));
            // Tạo settings cho mỗi ngày trong khoảng thời gian từ start_time đến end_time



            // Gọi hàm tạo settings với dữ liệu từ frontend
            $this->createSettingsForDriverTest($diverTest, $settingsData);

            // Gọi hàm tạo capa với dữ liệu từ frontend
            $this->createCapabilities($diverTest, $request->quantity);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Thêm thành công!",
                'data' => $diverTest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Summary of createSettingsForDriverTest
     * @param mixed $driverTest
     * @param mixed $settingsData
     * @return void
     */
    private function createSettingsForDriverTest($driverTest, $settingsData = null)
    {
        // Nếu có dữ liệu setting từ frontend
        if ($settingsData && is_array($settingsData)) {
            foreach ($settingsData as $setting) {
                if (!empty($setting->date)) {
                    Setting::create([
                        'test_driver_id' => $driverTest->id,
                        'date' => Carbon::parse($setting->date)->format('Y-m-d'),
                        'start' => $setting->start,
                        'end' => $setting->end,
                        'status' => $setting->status ?: 'Active' // Mặc định là 'Active' nếu status trống
                    ]);
                }
            }
        }
    }

    /**
     * Summary of create
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    private function createCapabilities($driverTest, $quantity)
    {
        try {
            $capa = new Capabilities();
            $capa->test_driver_id = $driverTest->id;
            $capa->quantity = $quantity;
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
     * // Handle ppdate the driver test
     * @param \App\Http\Requests\DriverTestRequest $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(DriverTestRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            // Cập nhật thông tin của DriverTest
            $diverTest = $this->driverTestRepository->update($id, $request->validated());

            $settings = $request->input('settings');
            $settingsData = json_decode($settings);

            // Cập nhật lại start_time và end_time
            $request->merge([
                'user_id' => auth()->user()->id,
            ]);
            $request['start_time'] = $settingsData[0]->date;

            // Trích xuất mảng các ngày từ $settingsData
            $dates = array_column($settingsData, 'date');

            // Tìm ngày lớn nhất trong mảng
            $request['end_time'] = max($dates);

            // Cập nhật DriverTest với các thông tin mới
            $diverTest->update($request->all());

            // Xóa các settings cũ của chương trình lái thử
            Setting::where('test_driver_id', $diverTest->id)->delete();

            // Tạo lại các settings mới
            $this->createSettingsForDriverTest($diverTest, $settingsData);

            // Xử lý ảnh (upload hoặc update ảnh)
            $request->merge(['driver_test_id' => $diverTest->id]);
            $this->imageController->update(new ImageUploadRequest($request->all()));

            // Gọi hàm tạo capa với dữ liệu từ frontend
            Capabilities::where('test_driver_id', $diverTest->id)->delete();
            $this->createCapabilities($diverTest, $request->quantity);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Cập nhật thành công!",
                'data' => $diverTest
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại chương trình lái thử trong hệ thống"
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function confirm(Request $request, $id)
    {
        try {

            $diverTest = $this->driverTestRepository->confirm($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => "Xét duyệt thành công",
                'data' => $diverTest
            ], 200);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại chương trình lái thử trong hệ thống"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle delete the driver test by id
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->driverTestRepository->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công!'
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại chương trình lái thử trong hệ thống"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
