<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\CreateProductRequest;
use App\Http\Requests\Admin\Product\ListProductReuqest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use App\Service\Admin\Product\CreateProductService;
use App\Service\Admin\Product\DeleteProductService;
use App\Service\Admin\Product\UpdateProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(ListProductReuqest $request)
    {
        $products = resolve(ProductRepository::class)->getAllProducts($request);
        $categories = resolve(CategoryRepository::class)->getCaregoriesWithSub();

        return view('admin.pages.product.listProducts', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = resolve(CategoryRepository::class)->getCaregoriesWithSub();

        return view('admin.pages.product.create', compact('categories'));
    }

    public function store(CreateProductRequest $request)
    {
        resolve(CreateProductService::class)
            ->setData($request)
            ->handle();

        return redirect()->route('admin.products')->with('status', 'Thêm mới thành công');
    }

    public function edit($id)
    {
        $product = resolve(ProductRepository::class)->getProductById($id);
        $categories = resolve(CategoryRepository::class)->getCaregoriesWithSub();
        $images = resolve(ImageRepository::class)->getImagesByProduct($id)->get();

        return view('admin.pages.product.update', compact('product', 'categories', 'images'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        resolve(UpdateProductService::class)
            ->setData($request)
            ->setModel($id)
            ->handle();

        return redirect()->route('admin.product.edit', $id)->with('status', 'Cập nhật thành công');;
    }

    public function destroy($id)
    {
        resolve(DeleteProductService::class)
            ->setModel($id)
            ->handle();

        return redirect()->route('admin.products')->with('status', 'Xoá thành công');;
    }

    public function deleteImage($id)
    {
        $image = resolve(ImageRepository::class)->getImageById($id);
        if ($image) {
            if(File::exists("products/".$image->name)){
                File::delete("products/".$image->name);
            }
            $image->delete();
        }

        return back();
    }
}
