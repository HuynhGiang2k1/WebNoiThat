<?php

namespace App\Repository;

use App\Models\Image;

class ImageRepository
{
    private $model;

    public function __construct(Image $image)
    {
        $this->model = $image;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function getImagesByProduct($id)
    {
        return $this->model->where('product_id', $id);
    }

    public function getImageById($id)
    {
        return $this->model->find($id);
    }
}
