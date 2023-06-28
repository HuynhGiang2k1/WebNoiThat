<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateSubCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateSubCategoryRequest;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = resolve(CategoryRepository::class)->getCategories();
        $subCategories = resolve(SubCategoryRepository::class)->getCategories();

        return view('admin.pages.category.subCategories', compact('subCategories', 'categories'));
    }

    public function store(CreateSubCategoryRequest $request)
    {
        resolve(SubCategoryRepository::class)->create($request->toArray());

        return redirect()->route('admin.subcategory');
    }

    public function update(UpdateSubCategoryRequest $request)
    {
        resolve(SubCategoryRepository::class)->update($request);

        return redirect()->route('admin.subcategory');
    }

    public function delete($id)
    {
        resolve(SubCategoryRepository::class)->delete($id);

        return redirect()->route('admin.subcategory');
    }
}
