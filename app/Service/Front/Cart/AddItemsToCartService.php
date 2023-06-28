<?php

namespace App\Service\Front\Cart;

use App\Repository\CartRepository;

class AddItemsToCartService
{
    protected $repository;
    protected $data;

    public function __construct(CartRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        $item = $this->repository->getItemByProductId($this->data->pid);

        if ($item) {
            $quantity = $item->quantity + $this->data->quantity;
            if ($quantity <= config('hf.cart.purchase_limit')) {
                $item->quantity = $quantity;
                $item->save();

                return false;
            }
            return $item->quantity;
        }

        if ($this->data->quantity <= config('hf.cart.purchase_limit')) {
            $data = [
                'user_id' => \Auth::id(),
                'product_id' => $this->data->pid,
                'quantity' => $this->data->quantity
            ];
            $this->repository->create($data);

            return false;
        }
        return 999;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
