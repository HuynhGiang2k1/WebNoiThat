<?php

namespace App\Http\Controllers\Front;

use App\Enums\OrderOptions;
use App\Enums\PayStatus;
use App\Helper\Pay;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Order\CheckoutRequest;
use App\Repository\CartRepository;
use App\Repository\OrderRepository;
use App\Repository\PayRepository;
use App\Repository\ProductRepository;
use App\Service\Front\Order\CreateOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class OrderController extends Controller
{
    public function index(CheckoutRequest $request)
    {
        $items = resolve(CartRepository::class)->getItemByIds(json_decode($request->cartIds))->get();
        if (!$items) {
            abort(404);
        }

        return view('front.pages.checkout', compact('items'));
    }

    public function confirm(Request $request)
    {
        $items = resolve(CartRepository::class)->getItemByIds(json_decode($request->cartIds))->get();
        if (!$items->toArray()) {
            abort(404);
        }

        return view('front.pages.confirm-checkout', compact('items', 'request'));
    }

    public function store(Request $request)
    {
        $initCart = resolve(CartRepository::class)->getItemByIds(json_decode($request->cartIds));
        if (!$initCart->get()->toArray()) {
            abort(404);
        }
        $order = resolve(CreateOrderService::class)
            ->setData($request)
            ->handle();

        if ($order->order_status == OrderOptions::PAYMENTONDELIVERY) {
            $initCart->delete();
            $rspCode = Crypt::encryptString('100.'.$order->id);
            return redirect()->route('order.complete', [$rspCode]);
        }

        return Pay::create($order);
    }

    public function vnpayReturn(Request $request)
    {
        $inputData = array();
        $returnData = array();

        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, env('VNPAY_HASHSECRET'));
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];

        try {
            if ($secureHash == $vnp_SecureHash) {
                $order = resolve(OrderRepository::class)->getOrderById($orderId);
                if ($order != NULL) {
                    $initCart = resolve(CartRepository::class)->getItemByIds(json_decode($order->cart_id));
                    if($order->money == $vnp_Amount) {
                        if ($order->status !== NULL && $order->status == 0) {
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                $status = PayStatus::PAID; // Trạng thái thanh toán thành công
                                $payData = [
                                    'order_id' => $order->id,
                                    'money'     => $order->money,
                                    'vnpay_code' => $inputData['vnp_BankTranNo'],
                                    'vnp_bank_code' => $inputData['vnp_BankCode'],
                                    'vnp_TransactionNo' => $inputData['vnp_TransactionNo'],
                                    'vnp_TmnCode' => $inputData['vnp_TmnCode'],
                                    'status' => $status
                                ];
                                resolve(PayRepository::class)->create($payData);
                                $initCart->delete();
                                $returnData['RspCode'] = '00.'.$order->id;
                            } else {
                                $status = PayStatus::PAYMENTFAILED; // Trạng thái thanh toán thất bại / lỗi
                                $returnData['RspCode'] = '010.'.$order->id;
                            }
                        } else {
                            $status = PayStatus::PAYMENTFAILED;
                            $returnData['RspCode'] = '02.'.$order->id;
                        }
                    }
                    else {
                        $status = PayStatus::PAYMENTFAILED;
                        $returnData['RspCode'] = '04.'.$order->id;
                    }
                    $itemCarts = $initCart->get();
                    foreach ($itemCarts as $item) {
                        resolve(ProductRepository::class)->increQuantity($item->product->id, $item->quantity);
                    }
                    $order->status = $status;
                    $order->cart_id = null;
                    $order->save();
                } else {
                    $returnData['RspCode'] = '01.'.$order->id;
                }
            } else {
                $returnData['RspCode'] = '97';
            }
        } catch (\Exception $e) {
            $returnData['RspCode'] = '99';
        }

        $rspCode = Crypt::encryptString($returnData['RspCode']);
        return redirect()->route('order.complete', [$rspCode]);
    }

    public function complete($token)
    {
        try {
            $rspCode = Crypt::decryptString($token);
        } catch (DecryptException $e) {
            $rspCode = 'error';
        }

        $order = null;
        $result = explode('.', $rspCode);
        if (count($result) > 1) {
            $order = resolve(OrderRepository::class)->getOrderByIdWithPay($result[1]);
        }
        $rspCode = $result[0];

        return view('front.pages.complete-checkout', compact('rspCode', 'order'));
    }

    public function updateSuccess($id)
    {
        $order =  resolve(OrderRepository::class)->getOrderById($id);
        $order->user_checked = 1;
        $order->status = PayStatus::PAID;
        $order->save();

        return redirect()->route('front.user.order');
    }
}
