<?php

namespace App\Repositories;

use App\Http\Controllers\MailController;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;

class CustomerRepository
{
    protected $model;
    protected $user;
    protected $perPage = 10;
    protected $mailController;



    public function __construct(Customer $customer, User $user, MailController $mailController)
    {
        $this->model = $customer;
        $this->user = $user;
        $this->mailController = $mailController;
    }

    public function getAll($filters = [])
    {
        $query = $this->model->query();

        $user_id = auth()->user()->id;
        $query->where('user_id', $user_id);
        // Apply filters
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        if (isset($filters['fullname'])) {
            $query->where('fullname', 'LIKE', "%{$filters['fullname']}%");
        }
        if (isset($filters['email'])) {
            $query->where('email', 'LIKE', "%{$filters['email']}%");
        }
        if (isset($filters['address'])) {
            $query->where('address', 'LIKE', "%{$filters['address']}%");
        }
        if (isset($filters['phone'])) {
            $query->where('phone', 'LIKE', "%{$filters['phone']}%");
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['sex'])) {
            $query->where('sex', $filters['sex']);
        }

        if (isset($filters['income'])) {
            $query->where('income', $filters['income']);
        }

        if (isset($filters['hobbit'])) {
            $query->where('hobbit', $filters['hobbit']);
        }

        if (isset($filters['owned'])) {
            $query->where('owned', $filters['owned']);
        }

        if (isset($filters['area'])) {
            $query->where('area', $filters['area']);
        }

        if (isset($filters['age'])) {
            $age = $filters['age'];

            // Trường hợp A-B
            if (strpos($age, '-') !== false) {
                $ageRange = explode('-', $age);
                if (count($ageRange) === 2) { // Đảm bảo A và B tồn tại
                    $startAge = intval($ageRange[0]);
                    $endAge = intval($ageRange[1]);
                    $query->whereBetween('age', [$startAge, $endAge]);
                }
            }
            // Trường hợp C+
            elseif (strpos($age, '+') !== false) {
                $minAge = intval($age); // Lấy giá trị trước "+"
                $query->where('age', '>=', $minAge);
            }
            // Trường hợp không hợp lệ
            else {
                // Bỏ qua hoặc báo lỗi
                // Ví dụ: throw new \InvalidArgumentException("Invalid age filter format.");
            }
        }

        // Sort
        $sortField = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDirection);

        return $query->get();
    }


    public function findById($id)
    {
        $customer = $this->model->findOrFail($id);
        if (!$customer) {
            throw new ModelNotFoundException("Không tồn tại khách hàng trong hệ thống");
        }

        return $customer;
    }

    public function create(array $data)
    {
        // Get showroom
        $user = auth()->user();

        // Get showroom
        $showroom = $this->user->where('account_id', $user->id)->first();

        // Send email to customer
        $this->mailController->sendCustomer($data, $showroom);

        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $customer = $this->findById($id);

        // Remove file image if exists
        File::delete(storage_path('app/public/' . $customer->img));

        $customer->update($data);
        return $customer;
    }

    public function delete($id)
    {
        $customer = $this->findById($id);
        return $customer->delete();
    }
}
