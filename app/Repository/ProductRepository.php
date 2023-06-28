<?php

namespace App\Repository;

use App\Models\Product;

class ProductRepository
{
    private $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getAllProducts($request, $discount = false)
    {
        return $this->model
            ->when($request->id, function ($q) use ($request) {
                return $q->where('id', $request->id);
            })
            ->when($request->name, function ($q) use ($request) {
                return $q->where('name', 'like', '%' . $request->name . '%');
            })
            ->when($request->has('categories'), function ($q) use ($request) {
                $q->orWhereHas('categories', function ($subQuery) use ($request) {
                    return $subQuery->whereIn('id', $request->categories);
                });
            })
            ->when($request->has('subcategories'), function ($q) use ($request) {
                $q->orWhereHas('subcategories', function ($subQuery) use ($request) {
                    return $subQuery->whereIn('id', $request->subcategories);
                });
            })
            ->when($discount, function ($q) {
                return $q->whereNull('discount_id');
            })
            ->with('images', 'subcategories', 'categories', 'discount')
            ->paginate(10);
    }

    public function createProduct($data)
    {
        return $this->model->create($data);
    }

    public function getProductById($id)
    {
        return $this->model->with('categories', 'subcategories', 'images')->findOrFail($id);
    }

    public function getProductOrderById($id)
    {
        return $this->model->with('categories', 'subcategories', 'images')->withTrashed()->findOrFail($id);
    }

    public function updateProduct($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function getProducts($subcategoryIds = null, $categoryId = null)
    {
        return $this->model
            ->when($categoryId, function ($q) use ($categoryId) {
                $q->orWhereHas('categories', function ($subQuery) use ($categoryId) {
                    return $subQuery->where('id', $categoryId);
                });
            })
            ->when($subcategoryIds, function ($q) use ($subcategoryIds) {
                $q->orWhereHas('subcategories', function ($subQuery) use ($subcategoryIds) {
                    return $subQuery->whereIn('id', $subcategoryIds);
                });
            })
            ->paginate(12);
    }

    public function updateDiscountProductsByIds($ids, $discountId)
    {
        return $this->model->whereIn('id', $ids)->update(['discount_id' => $discountId]);
    }

    public function countProducts()
    {
        return $this->model->whereNull('deleted_at')->count();
    }

    public function getProductsByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function relatedProducts($id, $categories = null, $subcategories = null)
    {
        return $this->model
            ->where('id', '!=',$id)
            ->when($categories, function ($q) use ($categories) {
                $q->orWhereHas('categories', function ($subQuery) use ($categories) {
                    return $subQuery->whereIn('id', $categories);
                });
            })
            ->when($subcategories, function ($q) use ($subcategories) {
                $q->orWhereHas('subcategories', function ($subQuery) use ($subcategories) {
                    return $subQuery->whereIn('id', $subcategories);
                });
            })
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    public function searchProducts($search)
    {
        return $this->model
            ->where('name', 'like', '%' . $search . '%')
            ->with('discount')
            ->paginate(12);
    }

    public function getProductsSale()
    {
        return $this->model
            ->with('discount')
            ->whereHas('discount')
            ->get();
    }

    public function decreQuantity($id, $quantity)
    {
        return $this->model->where('id', $id)->decrement('quantity', $quantity);
    }

    public function increQuantity($id, $quantity)
    {
        return $this->model->where('id', $id)->increment('quantity', $quantity);
    }

    public function listProductsByPrice($operator, $value)
    {
        return $this->model
            ->where('price', $operator, $value)
            ->inRandomOrder()
            ->limit(5)
            ->get();
    }
}
