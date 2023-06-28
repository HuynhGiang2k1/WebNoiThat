<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $countUsers = resolve(UserRepository::class)->countUsers();
        $countProducts = resolve(ProductRepository::class)->countProducts();
        $countOrders = resolve(OrderRepository::class)->countOrders();

        $initMonth = [];
        for ($i=1;$i<=12;$i++) {
            $initMonth[$i] = 0;
        }

        $users = resolve(UserRepository::class)->countUserByMonth();
        $userMonth = $initMonth;
        foreach ($users->toArray() as $item) {
            $userMonth[$item['month']] = $item['total'];
        }

        $orders = resolve(OrderRepository::class)->countOrderByMonth();
        $ordersMonth = $initMonth;
        foreach ($orders->toArray() as $item) {
            $ordersMonth[$item['month']] = $item['total'];
        }

        $chart = json_encode([
            array_values($userMonth),
            array_values($ordersMonth)
        ]);

        return view('admin.pages.dashboard', compact('countUsers', 'countProducts', 'countOrders', 'chart'));
    }
}
