<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Repositories\AccountRepository;

class UserController extends Controller
{

    protected $userRepository;
    protected $accountRepository;
    protected $mailController;

    /**
     * UserController constructor.
     * @param \App\Repositories\UserRepository $userRepository
     * @param \App\Repositories\AccountRepository $accountRepository
     * @param \App\Http\Controllers\MailController $mailController
     */
    public function __construct(UserRepository $userRepository, AccountRepository $accountRepository, MailController $mailController)
    {
        $this->userRepository = $userRepository;
        $this->accountRepository = $accountRepository;
        $this->mailController = $mailController;
    }

    /**
     * Handle get all user with filter
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {

            $filters = $request->only([
                'search',
                'fullname',
                'shortname',
                'email',
                'phone',
                'address',
                'MST',
                'website',
                'status',
                'type',
                'page',
                'sort_by',
                'sort_direction',
                'per_page'
            ]);

            $data = $this->userRepository->getAll($filters);

            $users = $data['data'];

            $users = $users->map(function ($user) {
                if ($user->account !== null) {
                    $user->status = $user->account->status;
                }
                unset($user->account);
                return $user;
            });
            // Lọc theo status nếu tồn tại trong filters
            if (isset($filters['status'])) {
                $statusFilter = $filters['status'];
                $users = $users->filter(function ($user) use ($statusFilter) {
                    return $user->status == $statusFilter;
                });
                $users = $users->values();
            }

            return response()->json([
                'success' => true,
                'message' => 'Lấy user thành công',
                'data' => $users,
                'totalRecord' => $data['total']
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle get the user by id
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $user = $this->userRepository->findById($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => "Không có user trong dữ liệu",
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => "Lấy user thành công",
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => "Không tìm thấy user trong hệ thống"
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Handle create a new user
     * @param \App\Http\Requests\UserRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        try {

            $file = $request->file('image');

            if ($file && $file->isValid()) {
                $path = $file->store('images', 'public');
                // Merge data into request
            } else {
                $path = "images/default.png";
            }

            $account = $this->accountRepository->create($request->validated());

            // Merge data into request
            $request->merge([
                'account_id' => $account->id,
                'logo' => $path
            ]);

            $user = $this->userRepository->create($request->all());


            return response()->json([
                'success' => true,
                'message' => "Thêm thành công!",
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle update the user by id
     * @param \App\Http\Requests\UserRequest $request
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        try {
            $file = $request->file('image');

            $path = "images/default.png";

            if ($file && $file->isValid()) {
                $path = $file->store('images', 'public');
                // Merge data into request
            } else {
                $path = $request['logo'];
            }

            $request->merge([
                'logo' => $path
            ]);

            // Store file
            $user = $this->userRepository->update($id, $request->all());

            return response()->json([
                'success' => true,
                'message' => "Sửa thành công",
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại user trong hệ thống"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle delete the user by id
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công!'
            ]);
        } catch (ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'message' => "Không tồn tại user trong hệ thống"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
