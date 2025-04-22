<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository
{
    protected $model;

    protected $account;

    protected $perPage = 10;
    protected $accountRepository;

    /**
     * UserRepository constructor.
     * @param User $user
     * @param AccountRepository $accountRepository
     */
    public function __construct(User $user, Account $account, AccountRepository $accountRepository)
    {
        $this->model = $user;
        $this->accountRepository = $accountRepository;
        $this->account = $account;
    }

    /**
     * Handle get all user with filter
     * @param array $filters
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll($filters = [])
    {
        $query = $this->model->query();
        $page = $filters['page'] ?? 1;
        $per_page = $filters['per_page'] ?? 10;

        // Tính offset
        $offset = ($page - 1) * $per_page;

        // Apply filters
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        if (isset($filters['fullname'])) {
            $query->where('fullname', 'LIKE', "%{$filters['fullname']}%");
        }
        if (isset($filters['shortname'])) {
            $query->where('shortname', 'LIKE', "%{$filters['shortname']}%");
        }
        if (isset($filters['MST'])) {
            $query->where('MST', 'LIKE', "%{$filters['MST']}%");
        }
        if (isset($filters['email'])) {
            $query->where('email', 'LIKE', "%{$filters['email']}%");
        }
        if (isset($filters['phone'])) {
            $query->where('phone', 'LIKE', "%{$filters['phone']}%");
        }
 

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['sex'])) {
            $query->where('sex', $filters['sex']);
        }

        // Sort
        $sortField = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        // Đếm tổng số bản ghi
        $total = $query->count();

        // Lấy dữ liệu với offset và limit
        $data = $query->with('account')
            ->skip($offset)
            ->take($per_page)
            ->get();

        return [
            'data' => $data,
            'total' => $total,
            'page' => (int)$page,
            'per_page' => (int)$per_page,
            'last_page' => ceil($total / $per_page)
        ];
    }

    /**
     * Handle find user by id
     * @param mixed $id
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function findById($id)
    {
        $user = $this->model->findOrFail($id);
        if (!$user) {
            throw new ModelNotFoundException("Không tồn tại user trong hệ thống");
        }

        return $user;
    }

    /**
     *
     * Handle create user
     * @param array $data
     * @return User|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->model->create($data);
    }

    /**
     * Handle update user
     * @param mixed $id
     * @param array $data
     * @return array|User|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        $user = $this->findById($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['image'])) {
            File::delete(storage_path('app/public/' . $user->logo));
        }

        $user->update($data);

        //Find Account
        $account = $this->account::where('id', $user->account_id)->firstOr();

        // Unset Filed phone
        unset($data['phone']);

        // Update Account
        $account->update($data);

        return $user;
    }

    /**
     * Handle delete user
     * @param mixed $id
     * @return bool|mixed|null
     */
    public function delete($id)
    {
        // Find user
        $user = $this->findById($id);

        // Delete account
        $this->accountRepository->delete($user->account_id);

        // Delete logo
        File::delete(storage_path('app/public/' . $user->logo));

        return $user->delete();
    }
}
