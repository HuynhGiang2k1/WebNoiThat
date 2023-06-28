<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Repository\CategoryRepository;
use App\Service\Admin\Category\CreateCategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = resolve(CategoryRepository::class)->getCategories();

        return view('admin.pages.category.categories', compact('categories'));
    }

    public function store(CreateCategoryRequest $request)
    {
        resolve(CategoryRepository::class)->create($request->toArray());

        return redirect()->route('admin.category');
    }

    public function update(UpdateCategoryRequest $request)
    {
        resolve(CategoryRepository::class)->update($request);

        return redirect()->route('admin.category');
    }

    public function delete($id)
    {
        resolve(CategoryRepository::class)->delete($id);

        return redirect()->route('admin.category');
    }
}
