<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PayStatus;
use App\Http\Controllers\Controller;
use App\Mail\CommonMail;
use App\Mail\OrderShipped;
use App\Repository\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrdersPending()
    {
        $orders = resolve(OrderRepository::class)->getOrdersPending();
        $approve = 0;

        return view('admin.pages.order.listOrders', compact('orders', 'approve'));
    }

    public function getOrdersApprove()
    {
        $orders = resolve(OrderRepository::class)->getOrdersApprove();
        $approve = 1;

        return view('admin.pages.order.listOrders', compact('orders', 'approve'));
    }

    public function getOrdersSuccess()
    {
        $orders = resolve(OrderRepository::class)->getOrdersSuccess();

        return view('admin.pages.order.listOrdersSuccess', compact('orders'));
    }

    public function getOrdersFail()
    {
        $orders = resolve(OrderRepository::class)->getOrdersFail();

        return view('admin.pages.order.listOrdersFail', compact('orders'));
    }

    public function update($id)
    {
        $order =  resolve(OrderRepository::class)->getOrderById($id);
        if ($order->shipping_status == 0) {
            $order->shipping_status = 1;
        } else {
            $order->shipping_status = 2;
            $order->verified_at = now();
            $mailData = [
                'to' => $order->email,
                'name' => $order->user_name,
                'subject' => 'Đơn hàng đã giao thành công',
                'view' => 'emails.orders.shipped',
                'data' => [
                    'order' => $order,
                ],
            ];
            \Mail::queue((new CommonMail($mailData)));
        }
        $order->save();

        return redirect()->route('admin.orders.pending');
    }

    public function delete($id)
    {
        $order = resolve(OrderRepository::class)->getOrderById($id);
        $order->status = PayStatus::DESTROY;
        $order->save();

        $mailData = [
            'to' => $order->email,
            'name' => $order->user_name,
            'subject' => 'Đơn hàng đã bị hủy',
            'view' => 'emails.orders.destroy',
            'data' => [
                'order' => $order,
            ],
        ];
        \Mail::queue((new CommonMail($mailData)));

        return redirect()->route('admin.orders.pending');
    }
}
