<?php

namespace App\Helper;

use Illuminate\Http\Request;

class Pay
{
    public static function create($order)
    {
        $vnp_Url = env('VNPAY_URL');

        $vnp_HashSecret = env('VNPAY_HASHSECRET');
        $vnp_BankCode = 'NCB';
        //Add Params of 2.0.1 Version
        //Billing
        if (isset($order->user_name) && trim($order->user_name) != '') {
            $name = explode(' ', $order->user_name);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $inputData = array(
            "vnp_Version"       => "2.1.0",
            "vnp_TmnCode"       => env('VNPAY_TMNCODE'),
            "vnp_Amount"        => $order->money * 100,
            "vnp_Command"       => "pay",
            "vnp_CreateDate"    => date('YmdHis'),
            "vnp_CurrCode"      => "VND",
            "vnp_IpAddr"        =>  $_SERVER['REMOTE_ADDR'],
            "vnp_Locale"        => 'vn',
            "vnp_OrderInfo"     => 'Thanh toán đơn hàng',
            "vnp_OrderType"     => 'billpayment',
            "vnp_ReturnUrl"     => route('vnpay.return'),
            "vnp_TxnRef"        => $order->id,
            "vnp_Bill_Mobile"   => $order->tel,
            "vnp_Bill_Email"    => $order->email,
            "vnp_Bill_FirstName"=> $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Bill_Address"  => $order->address,
            "vnp_Inv_Phone"     => $order->tel,
            "vnp_Inv_Email"     => $order->email,
            "vnp_Inv_Customer"  => $order->user_name,
            "vnp_Inv_Address"   => $order->address,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        header('Location: ' . $vnp_Url);
        die();
    }
}
