<?php

namespace App\Repository;

use App\Models\Cart;

class CartRepository
{
    private $model;

    public function __construct(Cart $cart)
    {
        $this->model = $cart;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function getItemsByUserId()
    {
        return $this->model->where('user_id', \Auth::id())->with('product.discount')->get();
    }

    public function getItemByProductId($productId)
    {
        return $this->model
            ->where('user_id', \Auth::id())
            ->where('product_id', $productId)
            ->first();
    }

    public function countCartItem()
    {
        return $this->model->where('user_id', \Auth::id())->count();
    }

    public function deleteCartItem($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function getItemById($id)
    {
        return $this->model->where('id', $id)->with('product.discount')->first();
    }

    public function getItemByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->with('product.discount');
    }

    public function deleteItemsByProductId($productId)
    {
        return $this->model->where('product_id', $productId)->delete();
    }
}
