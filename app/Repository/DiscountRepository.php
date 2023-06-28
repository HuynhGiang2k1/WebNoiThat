<?php

namespace App\Repository;

use App\Models\Discount;

class DiscountRepository
{
    private $model;

    public function __construct(Discount $discount)
    {
        $this->model = $discount;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function getDiscountById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getDiscountWithProduct($id)
    {
        return $this->model->with('products')->findOrFail($id);
    }

    public function update($id, $request)
    {
        return $this->model->where('id', $id)
            ->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'val'      => $request->val,
                'is_percent'    => isset($request->is_percent) ? 1 : 0,
                'term_start'    => strtotime($request->term_start),
                'term_end'      => strtotime($request->term_end),
            ]);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function updateProductsApply($productIds, $id)
    {
        return $this->model->where('id', $id)->update(['products_apply' => $productIds]);
    }

    public function initDiscountsApply($now)
    {
        return $this->model
            ->where('pickup', 0)
            ->where('term_start', '<', $now)
            ->where('term_end', '>', $now);
    }

    public function initDiscountsUnApply($now)
    {
        return $this->model
            ->where('pickup', 1)
            ->where('term_end', '<', $now);
    }
}
