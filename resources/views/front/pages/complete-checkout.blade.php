@extends('front.base')
@section('title', 'Thông tin thanh toán')

@section('content')
    <div class="content order cart">
        <div class="order-wrapper cart-wrapper">
            @if(in_array($rspCode, ['00', '100']))
                <h1 class="order-title">Đặt hàng thành công</h1>
                <table>
                    <tr>
                        <th>Mã đơn hàng:</th>
                        <td>{{$order->id}}</td>
                    </tr>
                    <tr>
                        <th>Phương thức thanh toán:</th>
                        <td>
                            @if($order->order_status == 0)
                                Thanh toán bằng VNPAY
                            @else
                                Thanh toán khi nhận hàng
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Sản phẩm:</th>
                        <td>
                            @foreach(json_decode($order->product_id) as $productInfo)
                                @php
                                    $product = \App\Helper\Common::getProductById($productInfo[0]);
                                @endphp
                                <div style="display: flex;">
                                    <div>
                                        <span>{{$product->name}}</span>
                                        <span>({{$productInfo[2]}})</span>
                                    </div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>Thời gian dự kiến giao hàng:</th>
                        <td>5-6 ngày</td>
                    </tr>
                    <tr>
                        <th>Tổng tiền:</th>
                        <td>{{$order->money}}</td>
                    </tr>
                    <tr>
                        <th>Tình trạng:</th>
                        <td>
                            @if($order->pay)
                                Đã thanh toán
                            @else
                                Chưa thanh toán
                            @endif
                        </td>
                    </tr>
                </table>
                <div class="my-order">
                    <a href="{{route('front.user.order')}}">Đơn hàng của tôi</a>
                </div>
            @elseif(in_array($rspCode, ['02', '04', '01', '97', '99', '010']))
                <h1 class="order-title">Đặt hàng thất bại</h1>
                @if($order)
                    <table>
                        <tr>
                            <th>Mã đơn hàng:</th>
                            <td>{{$order->id}}</td>
                        </tr>
                        <tr>
                            <th>Sản phẩm:</th>
                            <td>
                                @foreach(json_decode($order->product_id) as $productInfo)
                                    @php
                                        $product = \App\Helper\Common::getProductById($productInfo[0]);
                                    @endphp
                                    <div style="display: flex;">
                                        <div>
                                            <span>{{$product->name}}</span>
                                            <span>({{$productInfo[2]}})</span>
                                        </div>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán:</th>
                            <td>
                                @if($order->order_status == 0)
                                    Thanh toán bằng VNPAY
                                @else
                                    Thanh toán khi nhận hàng
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tổng tiền:</th>
                            <td>{{$order->money}}</td>
                        </tr>
                    </table>
                @endif
            @else
                <h1>Không tìm thấy kết quả</h1>
            @endif

            <div class="my-order order-home">
                <a href="{{route('home')}}">Trở về trang chủ</a>
            </div>
        </div>
    </div>
    <style>
        .order{
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .order-wrapper{
            width:500px;
        }

        .order-title{
            color: #938880;
            font-family: Tahoma;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 18px;
            line-height: 1.5em;
            letter-spacing: .12em;
            border-bottom: 1px solid #938880;
            padding: 10px;
            margin-bottom:20px;
            text-align: center;
        }

        .order table{
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .order table tr{
            line-height: 1.5em;
        }

        .order table tr th{
            font-family: "Josefin Sans",sans-serif;
            text-transform: uppercase;
            color: #1d1d1d;
            font-size: 13px;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .order table tr td{
            font-family: "EB Garamond",serif;
            font-size: 17px;
            font-weight: 400;
            font-style: italic;
            color: #8b8b8b;
        }

        .my-order{
            width: 100%;
            margin-top: 10px;
        }

        .my-order a{
            font-family: "Open Sans",sans-serif;
            font-size: 17px;
            line-height: 1.8em;
            font-weight: 400;
            letter-spacing: 1px;
            color: #8b8b8b;
            transition: all 1s ease;
        }

        .my-order a:hover{
            color: #1d1d1d;
        }

    </style>
@endsection
