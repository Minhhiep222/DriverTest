<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository
{
    protected $model;

    public function __construct(Image $image)
    {
        $this->model = $image;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findByTestDriverId($id)
    {
        return $this->model->where('driver_test_id', $id)->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        $image = $this->findById($id);
        return $image->delete();
    }
}
