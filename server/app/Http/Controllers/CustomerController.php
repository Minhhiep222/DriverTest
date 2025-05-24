<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepository;
use App\Http\Requests\CustomerRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerController extends Controller
{
    protected $customerRepository;

    /**
     * CustomerController constructor.
     * @param \App\Repositories\CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Handle get all customer with filter
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            // Filter data
            $filters = $request->only([
                'search',
                'status',
                'fullname',
                'email',
                'phone',
                'address',
                'age',
                'area',
                'sex',
                'type',
                'income',
                'owned',
                'members',
                'sort_by',
                'sort_direction',
                'per_page'
            ]);

            $customers = $this->customerRepository->getAll($filters);

            return response()->json([
                'success' => true,
                'message' => 'Lấy khách hàng thành công3',
                'customer' => $customers,
                'totalRecord' => count($customers)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle get the customer by id
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {

            $customer = $this->customerRepository->findById($id);

            // Check if customer not found
            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => "Không có khách hàng trong dữ liệu",
                ], 404);
            }

            // Return customer
            return response()->json([
                'success' => true,
                'message' => "Lấy khách hàng thành công",
                'data' => $customer
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy khách hàng trong hệ thống"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Handle create a new customerS
     * @param \App\Http\Requests\CustomerRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(CustomerRequest $request)
    {
        try {
            // Kiểm tra file hình ảnh và xử lý đường dẫn
            $file = $request->file('image');
            if ($file && $file->isValid()) {
                // Lưu tệp vào thư mục 'images' trong public disk
                $path = $file->store('images', 'public');
            } else {
                // Sử dụng giá trị mặc định nếu không có file hoặc file không hợp lệ
                $path = 'images/default.png';
            }

            // Gán các thông tin khác vào request
            $request->merge([
                'user_id' => auth()->user()->id,
                'img' => $path
            ]);

            // Tạo khách hàng mới
            $customer = $this->customerRepository->create($request->all());

            return response()->json([
                'success' => true,
                'message' => "Thêm thành công!",
                'data' => $customer
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Handle update the customer
     * @param \App\Http\Requests\CustomerRequest $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(CustomerRequest $request, $id)
    {
        try {
            // Update customer
            $file = $request->file('image');
            $path = "images/default.png";
            // Store file
            if ($file && $file->isValid()) {
                $path = $file->store('images', 'public');
                // Merge data into request
            } else {
                $path = $request['img'];
            }

            // Merge data into request
            $request->merge([
                'img' => $path
            ]);

            $customer = $this->customerRepository->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => "Sửa thành công",
                'data' => $customer
            ], 200);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại khách hàng trong hệ thống"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle delete the customer
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->customerRepository->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công!'
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại khách hàng trong hệ thống"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
