<?php

namespace App\Repository;

use App\Models\Pay;

class PayRepository
{
    private $model;

    public function __construct(Pay $pay)
    {
        $this->model = $pay;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
