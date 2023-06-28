<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repository\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Front\User\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('front.user.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('front.user.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        $data = [
            'name' => $request->name,
            'tel'  => $request->tel,
            'address' => $request->street.'-'.$request->ward.'-'.$request->district.'-'.$request->province,
        ];

        if (!$request->password) {
            unset($request['password']);
        } else {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')){
            if(File::exists("avatars/".Auth::user()->avatar)){
                File::delete("avatars/".Auth::user()->avatar);
            }
            $file = $request->file("avatar");
            $imageName = $file->hashName();
            $file->move(\public_path("avatars/"), $imageName);
            $data['avatar'] = $imageName;
        }

        Auth::user()->update($data);

        return redirect()->route('front.user.profile');
    }

    public function getMyOrders()
    {
        $orders = resolve(OrderRepository::class)->getOrdersByUserId(\Auth::id());

        return view('front.user.order', compact('orders'));
    }

    public function getMyOrdersPaid()
    {
        $orders = resolve(OrderRepository::class)->getOrdersPaidByUserId(\Auth::id());

        return view('front.user.order-paid', compact('orders'));
    }
}
