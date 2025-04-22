<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookDriverRequest;
use Illuminate\Http\Request;
use App\Repositories\BookDriverRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class BookDriverController extends Controller
{
    protected $bookDriverRepository;
    protected $accountRepository;
    protected $mailController;

    /**
     * nhật kýController constructor.
     * @param \App\Repositories\BookDriverRepository $bookDriverRepository
     * @param \App\Http\Controllers\MailController $mailController
     */
    public function __construct(BookDriverRepository $bookDriverRepository, MailController $mailController)
    {
        $this->bookDriverRepository = $bookDriverRepository;
        $this->mailController = $mailController;
    }

    /**
     * Handle get all nhật ký with filter
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {

            $filters = $request->only([
                'search',
                'status',
                'type',
                'page',
                'driver_test_id',
                'sort_by',
                'sort_direction',
                'per_page'
            ]);

            $data = $this->bookDriverRepository->getAll($filters);

            return response()->json([
                'success' => true,
                'message' => 'Lấy nhật ký thành công',
                'data' => $data,
                // 'totalRecord' => $data['total']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function check(Request $request)
    {
        try {

            $data = $this->bookDriverRepository->checkAll($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Lấy giờ hết hạn thành công thành công',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle get the nhật ký by id
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $book = $this->bookDriverRepository->findById($id);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => "Không có nhật ký trong dữ liệu",
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => "Lấy nhật ký thành công",
                'data' => $book
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy nhật ký trong hệ thống"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Handle create a new nhật ký
     * @param \App\Http\Requests\BookDriverRequest
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(BookDriverRequest $request)
    {
        try {

            $book = $this->bookDriverRepository->create($request->all());

            if ($book == 'BEYOND_CAPATICY') {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        [
                            'field' => 'time_drive',
                            'message' => "Quá số lượng người đăng ký trong một giờ vui lòng chọn giờ khác!",
                        ]
                    ]
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => "Bạn đã đăng ký thành công. hệ thống sẽ liên hệ xác nhận thông tin trong thời gian tới!",
                'data' => $book
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle update the nhật ký by id
     * @param \App\Http\Requests\BookDriverRequest
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            // Store file
            $book = $this->bookDriverRepository->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => "Sửa thành công",
                'data' => $book
            ], 200);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại nhật ký trong hệ thống"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle delete the nhật ký by id
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->bookDriverRepository->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công!'
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại nhật ký trong hệ thống"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
