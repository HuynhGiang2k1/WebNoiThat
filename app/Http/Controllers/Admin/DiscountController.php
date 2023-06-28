<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Discount\ApplicableProductsRequest;
use App\Http\Requests\Admin\Discount\CreateDiscountRequest;
use App\Http\Requests\Admin\Discount\UpdateDiscountRequest;
use App\Http\Requests\Admin\Product\ListProductReuqest;
use App\Repository\CategoryRepository;
use App\Repository\DiscountRepository;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = resolve(DiscountRepository::class)->getAll();
        return view('admin.pages.discount.listDiscounts', compact('discounts'));
    }

    public function create()
    {
        return view('admin.pages.discount.create');
    }

    public function store(CreateDiscountRequest $request)
    {
        $data = $request->toArray();
        if (isset($request->is_percent)) {
            $data['is_percent'] = 1;
        } else {
            $data['is_percent'] = 0;
        }
        $data['term_start'] = strtotime($data['term_start']);
        $data['term_end'] = strtotime($data['term_end']);

        resolve(DiscountRepository::class)->create($data);

        return redirect()->route('admin.discounts')->with('status', 'Thêm mới thành công');;
    }

    public function show($id)
    {
        $discount = resolve(DiscountRepository::class)->getDiscountWithProduct($id);
        $products = [];
        if ($discount->products_apply) {
            $products = resolve(ProductRepository::class)->getProductsByIds(json_decode($discount->products_apply));
        }
        return view('admin.pages.discount.show', compact('discount', 'products'));
    }

    public function edit($id)
    {
        $discount = resolve(DiscountRepository::class)->getDiscountById($id);

        return view('admin.pages.discount.update', compact('discount'));
    }

    public function update(UpdateDiscountRequest $request, $id)
    {
        resolve(DiscountRepository::class)->update($id, $request);

        return redirect()->back()->with('status', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        resolve(DiscountRepository::class)->delete($id);

        return redirect()->route('admin.discounts')->with('status', 'Xoá thành công');
    }

    public function showFormApply(ListProductReuqest $request, $id)
    {
        $products = [];
        if (!empty($request->all()) && ($request->id || $request->name || $request->categories || $request->subcategories)) {
            $products = resolve(ProductRepository::class)->getAllProducts($request, true);
        }
        $categories = resolve(CategoryRepository::class)->getCaregoriesWithSub();
        return view('admin.pages.discount.apply', compact('products', 'categories', 'id'));
    }

    public function applicableProducts(Request $request, $id)
    {
        resolve(DiscountRepository::class)->updateProductsApply($request->productIds, $id);

        return redirect()->route('admin.discount.detail', [$id]);
    }
}
