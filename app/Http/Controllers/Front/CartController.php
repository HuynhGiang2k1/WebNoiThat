<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repository\CartRepository;
use App\Service\Front\Cart\AddItemsToCartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = resolve(CartRepository::class)->getItemsByUserId();

        return view('front.pages.cart', compact('items'));
    }

    public function store(Request $request)
    {
        $result = resolve(AddItemsToCartService::class)
            ->setData($request)
            ->handle();

        if ($result) {
            return redirect()->back()->with('errors', $result);
        }

        return redirect()->back()->with('success', 'ok');
    }

    public function update(Request $request)
    {
        $item = resolve(CartRepository::class)->getItemById($request->cartid);
        $item->quantity = $request->qty;
        $item->save();
        $price = $item->product->price;
        if ($item->product->discount) {
            if ($item->product->discount->val < 100) {
                $price = $price * (1 - $item->product->discount->val/100);
            } else {
                $price = $price - $item->product->discount->val;
            }
        }

        return response()->json(
            [
                'id'        => $item->id,
                'quantity'  => $item->quantity,
                'price'     => $price
            ]
        );
    }

    public function destroy($id)
    {
        resolve(CartRepository::class)->deleteCartItem($id);

        return redirect()->back();
    }

}
