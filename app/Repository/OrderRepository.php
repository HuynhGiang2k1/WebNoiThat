<?php

namespace App\Repository;

use App\Enums\PayStatus;
use App\Models\Order;

class OrderRepository
{
    private $model;

    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function getOrderById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function getOrderByIdWithPay($id)
    {
        return $this->model->with('pay')->findOrFail($id);
    }

    public function getOrdersByUserId($userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->whereNot('status', PayStatus::PAYMENTFAILED)
            ->whereNot('user_checked', 1)
            ->with('pay')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function getOrdersPaidByUserId($userId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('user_checked', 1)
            ->whereNot('status', PayStatus::PAYMENTFAILED)
            ->with('pay')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function getOrdersPending()
    {
        return $this->model
            ->where('shipping_status', 0)
            ->whereNot('status', PayStatus::DESTROY)
            ->paginate(10);
    }

    public function getOrdersApprove()
    {
        return $this->model
            ->where('shipping_status', 1)
            ->paginate(10);
    }

    public function getOrdersSuccess()
    {
        return $this->model->where('user_checked', 1)->paginate(10);
    }

    public function getOrdersFail()
    {
        return $this->model->where('status', 2)->paginate(10);
    }

    public function delete($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function countOrders()
    {
        return $this->model->whereNull('deleted_at')->count();
    }

    public function countOrderByMonth()
    {
        return $this->model
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', '=', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}
