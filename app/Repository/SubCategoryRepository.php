<?php

namespace App\Repository;

use App\Models\SubCategory;

class SubCategoryRepository
{
    private $model;

    public function __construct(SubCategory $category)
    {
        $this->model = $category;
    }

    public function getCategories()
    {
        return $this->model->orderBy('category_id')->with('category')->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($data)
    {
        return $this->model->where('id', $data->id)
            ->update([
                'name' => $data->name,
                'name_en' => $data->name_en,
                'category_id' => $data->category_id
            ]);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function getSubCategoryByName($name)
    {
        return $this->model->where('name_en', $name)->with('category')->first();
    }
}
