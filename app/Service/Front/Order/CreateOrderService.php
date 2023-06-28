<?php

namespace App\Service\Front\Order;

use App\Enums\OrderOptions;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\DB;

class CreateOrderService
{
    protected $repository;
    protected $cartRepo;
    protected $productRepo;
    protected $data;

    public function __construct(OrderRepository $repository,
                                CartRepository $cartRepo,
                                ProductRepository $productRepo)
    {
        $this->repository = $repository;
        $this->cartRepo   = $cartRepo;
        $this->productRepo= $productRepo;
    }

    public function handle()
    {
        return DB::transaction(function () {
            $initItems = $this->cartRepo->getItemByIds(json_decode($this->data->cartIds));

            $items = $initItems->get();
            if (!$items) {
                abort(404);
            }

            $data = $this->handleData($items);

            foreach ($items as $item) {
                $this->productRepo->decreQuantity($item->product->id, $item->quantity);
            }

            return $this->repository->create($data);
        });
    }

    public function handleData($items)
    {
        $data = [
            'email'         => $this->data->email,
            'tel'           => $this->data->phone,
            'address'       => $this->data->street . ', ' . $this->data->ward . ', ' . $this->data->district . ', ' . $this->data->province,
            'user_id'       => \Auth::id(),
            'user_name'     => $this->data->name,
            'send_memo'     => $this->data->orderNotes ?? '',
            'shipping_fee'  => $this->data->payOption? 0 : 100000,
            'verified_at'   => now(),
            'order_status'  => $this->data->payOption? OrderOptions::ONLINEPAYMENT : OrderOptions::PAYMENTONDELIVERY,
            'cart_id'       => json_encode($items->modelKeys()),
        ];
        $money = 0;
        foreach ($items as $item) {
            $price = $item->product->price;
            if ($item->product->discount) {
                if ($item->product->discount->val <= 100) {
                    $price = $price * (1 - $item->product->discount->val/100);
                } else {
                    $price = $price - $item->product->discount->val;
                }
            }
            $money += $price * $item->quantity;
            $products[] = [
                $item->product->id,
                $item->product->price,
                $item->quantity,
                $item->product->discount ? $item->product->discount->val : 0
            ];
        }
        $data['product_id'] = json_encode($products);
        $data['money'] = $money;

        return $data;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

}
