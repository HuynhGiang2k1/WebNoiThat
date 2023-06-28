<?php

namespace App\Repository;

use App\Models\Category;
use function Symfony\Component\Translation\t;

class CategoryRepository
{
    private $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getCategories()
    {
        return $this->model->all();
    }

    public function getCaregoriesWithSub()
    {
        return $this->model->with('subcategories')->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($data)
    {
        return $this->model->where('id', $data->id)->update(['name' => $data->name, 'name_en' => $data->name_en]);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function getCategoryByName($name)
    {
        return $this->model->with('subcategories')->where('name_en', $name)->first();
    }
}
