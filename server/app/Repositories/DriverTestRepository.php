<?php

namespace App\Repositories;

use App\Models\TestDriver;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DriverTestRepository
{
    protected $model;
    protected $perPage = 10;

    public function __construct(TestDriver $driverTest)
    {
        $this->model = $driverTest;
    }

    /**
     * Handle get program by user
     * @param mixed $filters
     * @return mixed
     */
    public function getByUser($filters = [])
    {
        $query = $this->model->query();
        $query->where('user_id', auth()->user()->id);
        return $this->getProgramDrive($filters, $query);
    }

    /**
     * Summary of getByAdmin
     * @param mixed $filters
     */
    public function getByAdmin($filters = [])
    {
        $query = $this->model->query();

        // Lọc những chương trình có ngày kết thúc lớn hơn ngày hiện tại
        $query->where('end_time', '>', now())->where('confirm', 'no');

        return $this->getProgramDrive($filters, $query);
    }

    /**
     * Handle get all program
     * @param mixed $filters
     * @return mixed
     */
    public function getAll($filters = [])
    {
        $query = $this->model->query();

        // Lọc những chương trình có ngày kết thúc lớn hơn ngày hiện tại
        $query->where('end_time', '>', now())->where('confirm', operator: 'yes');

        return $this->getProgramDrive($filters, $query);
    }

    /**
     * Handle get program by filters with query
     * @param mixed $filters
     * @param mixed $query
     * @return mixed
     */
    public function getProgramDrive($filters = [], $query)
    {
        $page = $filters['page'] ?? 1;
        $per_page = $filters['per_page'] ?? 10;

        // Tính offset
        $offset = ($page - 1) * $per_page;

        // Apply filters
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('location', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('showroom', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }


        if (isset($filters['location'])) {
            $query->where('location', 'LIKE', "%{$filters['location']}%");
        }

        if (isset($filters['name'])) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }

        if (isset($filters['vehicle_type'])) {
            $query->where('vehicle_type', 'LIKE', "%{$filters['vehicle_type']}%");
        }

        if (isset($filters['showroom'])) {
            $query->where('showroom', 'LIKE', "%{$filters['showroom']}%");
        }

        // Thêm giờ mặc định nếu chỉ có ngày được truyền lên
        if (!empty($filters['start_time'])) {
            $filters['start_time'] .= ' 00:00:00'; // Bắt đầu ngày
            $query->where('start_time', '>=', $filters['start_time']);
        }

        if (!empty($filters['end_time'])) {
            $filters['end_time'] .= ' 23:59:59'; // Kết thúc ngày
            $query->where('end_time', '<=', $filters['end_time']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Sort
        $sortField = $filters['sort_by'] ?? 'created_at';

        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $query->orderBy($sortField, $sortDirection);

        // Đếm tổng số bản ghi
        $total = $query->count();


        $data = $query->with('images')->skip($offset)
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


    public function findById($id)
    {
        $driverTest = $this->model->findOrFail($id);
        if (!$driverTest) {
            throw new ModelNotFoundException("Không tồn tại chương trình trong hệ thống");
        }

        return $driverTest;
    }

    public function findByIdWithImage($id)
    {
        $driverTest = $this->model->findOrFail($id)->where('id', $id)->with('images')->firstOr();
        if (!$driverTest) {
            throw new ModelNotFoundException("Không tồn tại chương trình trong hệ thống");
        }

        return $driverTest;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $driverTest = $this->findById($id);
        $driverTest->update($data);
        return $driverTest;
    }

    public function confirm($id, array $data)
    {
        $driverTest = $this->findById($id);
        $driverTest->confirm = $data['confirm'];
        $driverTest->save();
        return $driverTest;
    }

    public function delete($id)
    {
        $driverTest = $this->findById($id);
        return $driverTest->delete();
    }
}
