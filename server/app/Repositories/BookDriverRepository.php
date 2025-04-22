<?php

namespace App\Repositories;

use App\Models\BookDriver;
use App\Models\Capabilities;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookDriverRepository
{
    protected $model;
    protected $capabilities;
    protected $perPage = 10;

    public function __construct(BookDriver $dookDriver, Capabilities $capabilities)
    {
        $this->model = $dookDriver;
        $this->capabilities = $capabilities;
    }

    public function getAll($filters = [])
    {
        $query = $this->model->query();
        $query->where('driver_test_id', $filters['driver_test_id']);


        // Apply filters
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('location', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if (isset($filters['start_time'])) {
            $query->where('start_time', $filters['start_time']);
        }

        if (isset($filters['end_time'])) {
            $query->where('end_time', $filters['end_time']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Sort
        $sortField = $filters['sort_by'] ?? 'created_at';

        $sortDirection = $filters['sort_direction'] ?? 'desc';

        // Sắp xếp ưu tiên theo status - Active lên đầu, Inactive xuống cuối
        $query->orderByRaw("CASE WHEN status = 'Active' THEN 0 ELSE 1 END");

        $query->orderBy($sortField, $sortDirection);

        return $query->with('books')->get();
    }

    public function checkAll($array)
    {

        $capabilities = $this->capabilities->where('id', $array['driver_test_id'])->first();

        $books = $this->model->where('driver_test_id', $array['driver_test_id'])->where('date_drive', $array['date_drive'])->get();

        $times = [];
        $count = [];

        foreach ($books as $index => $book) {
            // Kiểm tra số lần xuất hiện của thời gian
            if (!isset($count[$book->time_drive])) {
                $count[$book->time_drive] = 0;
            }

            // Tăng số lần xuất hiện của thời gian
            $count[$book->time_drive]++;

            // Nếu số lần xuất hiện của thời gian >= số lượng khả năng
            if(isset($capabilities->quantity)) { 
                if ($count[$book->time_drive] >= $capabilities->quantity) {
                    $times[$index] = $book->time_drive;
                }
            }
        }

        return $times;
    }


    public function findById($id)
    {
        $driverTest = $this->model->findOrFail($id);
        if (!$driverTest) {
            throw new ModelNotFoundException("Không tồn tại chương trình trong hệ thống");
        }

        return $driverTest;
    }

    /**
     * Handle Create booking
     * @param array $data
     * @return BookDriver|string|\Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $capabilities = $this->capabilities->first();

        $books = $this->model
            ->where('time_drive', $data['time_drive'])
            ->where('date_drive', $data['date_drive'])->get();

        if (count($books) >= $capabilities->quantity) {
            return "BEYOND_CAPATICY";
        } else {
            return $this->model->create($data);
        }
    }

    public function update($id, array $data)
    {
        $driverTest = $this->findById($id);
        $driverTest->update($data);
        return $driverTest;
    }

    public function delete($id)
    {
        $driverTest = $this->findById($id);
        return $driverTest->delete();
    }
}
