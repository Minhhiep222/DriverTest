<?php

namespace App\Repositories;

use App\Http\Controllers\MailController;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mail;
use Request;

class AccountRepository
{
    protected $model;
    protected $perPage = 10;
    protected $mailController;

    public function __construct(Account $acount, MailController $mailController)
    {
        $this->model = $acount;
        $this->mailController = $mailController;
    }

    public function getAll($filters = [])
    {
        $query = $this->model->query();

        // Apply filters
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
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

        return $query->get();
    }

    public function findById($id)
    {
        $acount = $this->model->findOrFail($id);
        if (!$acount) {
            throw new ModelNotFoundException("Không tồn tại acount trong hệ thống");
        }

        return $acount;
    }

    public function create(array $data)
    {
        // Generate password
        $password = Str::random(6);
        $data['password'] = $password;

        // Send email
        $this->mailController->sendUser($data);

        // Hash password
        $data['password'] = Hash::make($password);

        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $acount = $this->findById($id);
        $acount->update($data);
        return $acount;
    }

    public function delete($id)
    {
        $acount = $this->findById($id);
        return $acount->delete();
    }
}
