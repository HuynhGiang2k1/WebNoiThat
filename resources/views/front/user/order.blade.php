@extends('front.user.sidebar')
{{--@section('title', 'aaa')--}}

@section('myPageContent')
    <table class="order-my">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Họ và tên
                <th>Địa chỉ</th>
                <th>Giá tiền</th>
                <th>Trạng thái thanh toán</th>
                <th>Trạng thái đơn hàng</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>
                    @foreach(json_decode($order->product_id) as $productInfo)
                        @php
                            $product = \App\Helper\Common::getProductById($productInfo[0]);
                            $price = $productInfo[1];
									if ($productInfo[3]) {
										if ($productInfo[3] < 100) {
                                            $price = $price * (1 - $productInfo[3]/100);
                                        } else {
                                            $price = $price - $productInfo[3];
                                        }
									}
                        @endphp
                        <div style="display: flex; align-items: center;">
                            <img style="border-radius: 10px;" src="{{asset('products/'.$product->cover)}}" height="100px">
                            <div>
                                <p style="color: #1d1d1d; font-weight: bold">{{$product->name}}</p>
                                @if($productInfo[3])
                                    <p style="color: #1d1d1d; font-weight: bold">
                                        <del>{{$productInfo[1]}}</del>
                                    </p>
                                    <span >{{$price}}</span>
                                    <span>x {{$productInfo[2]}}</span>
                                @else
                                    <span>{{$productInfo[1]}}</span>
                                    <span>x {{$productInfo[2]}}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </td>
                <td>{{$order->user_name}}</td>
                <td>{{$order->address}}</td>
                <td>{{$order->money}}</td>
                <td>
                    @if($order->status == 1)
                        Đã thanh toán
                    @else
                        Chưa thanh toán
                    @endif
                </td>
                <td>
                    @if($order->status == 3)
                        <span style="color: red">Đơn hàng đã bị huỷ</span>
                    @elseif($order->shipping_status == 2)
                        <form action="{{route('admin.order.success.update', [$order->id])}}" method="post" class="d-inline-block">
                            @csrf
                            @method('post')
                            <button class="btn btn-success btn-sm btn-success-product" type="submit">
                                Đã nhận được hàng
                            </button>
                        </form>
                    @elseif($order->shipping_status == 1)
                        Đang vận chuyển
                    @else
                        Đang chờ lấy hàng
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}

    <style>
        .order-my{
            width: 100%;
        }

        .order-my thead tr{
            height: 80px;
        }
        .order-my thead tr th{
            position: relative;
            font-family: "Josefin Sans",sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            color: #1d1d1d;
            font-size: 13px;
            line-height: 1.6em;
            letter-spacing: .2em;
        }

        .order-my thead tr th:after{
            position: absolute;
            display: block;
            bottom: 0;
            left: 0;
            content: " ";
            height: 1px;
            width: 100%;
            background-color: #c0bebe;
        }

        .order-my tbody tr{
            min-height:150px;
        }

        .order-my tbody tr td{
            position: relative;
            font-family: "EB Garamond",serif;
            font-size: 16x;
            color: #1d1d1d;
            font-style: italic;
            text-align: center;
            line-height: 26px;
        }

        .order-my tbody tr td img{
            margin: 10px 0;
        }

        .order-my tbody tr td:after{
            position: absolute;
            display: block;
            bottom: 0;
            left: 0;
            content: " ";
            height: 1px;
            width: 100%;
            background-color: #c0bebe;
        }

        .btn-success-product{
            background-color: #fff;
            outline: none;
            border-radius:5px;
            border: 1px solid #1d1d1d;
            padding: 4px 4px;
            color: #8a8a8a;
        }

        .btn-success-product:hover{
            border: 1px solid #ccc;
            color: #1d1d1d;
            cursor: pointer;
        }
    </style>
@endsection
