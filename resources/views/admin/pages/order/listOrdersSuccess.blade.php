@extends('admin.base')

@section('page-content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Danh sách đơn hàng thành công</h4>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <div class="d-md-flex mb-3">
                            <a href="{{route('admin.orders.success')}}" class="btn btn-outline-primary">Đơn hàng thành công</a>
                            <a href="{{route('admin.orders.pending')}}" class="btn btn-outline-primary">Đang chờ xác nhận</a>
                            <a href="{{route('admin.orders.approve')}}" class="btn btn-outline-primary">Đang vận chuyển</a>
                            <a href="{{route('admin.orders.fail')}}" class="btn btn-outline-primary">Đơn hàng thất bại</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table no-wrap">
                                <thead>
                                <tr>
                                    <th class="border-top-0">Sản phẩm</th>
                                    <th class="border-top-0">Thanh toán</th>
                                    <th class="border-top-0">Giao hàng</th>
                                    <th class="border-top-0">Trạng thái thanh toán</th>
                                    <th class="border-top-0">Trạng thái đơn hàng</th>
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
                                                <div style="display: flex;">
                                                    <img src="{{asset('products/'.$product->cover)}}" height="60px">
                                                    <div>
                                                        <p>{{$product->name}}</p>
                                                        @if($productInfo[3])
                                                            <p>
                                                                <del>{{$productInfo[1]}}</del>
                                                            </p>
                                                            <span>{{$price}}</span>
                                                            <span>x {{$productInfo[2]}}</span>
                                                        @else
                                                            <span>{{$productInfo[1]}}</span>
                                                            <span>x {{$productInfo[2]}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>{{$order->money}}</td>
                                        <td>
                                            @if($order->order_status == 0)
                                                Thanh toán bằng VNPAY
                                            @else
                                                Thanh toán khi nhận hàng
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-success">Đã thanh toán</span>
                                        </td>
                                        <td>
                                            <span class="text-success">Đã nhận hàng</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{ $orders->links() }}
        </div>
    </div>
@endsection

<style>

    html ::-webkit-scrollbar {
        border-radius: 0;
        height: 9px;
        width: 9px;
    }

    html ::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,.15);
        border-radius: 4px;
    }

    .form-search-product{
        position: relative;
        width: 100%;
        font-family: "EB Garamond",serif;
        font-size: 18px;
        font-weight: 400;
    }

    .form-search-product::after{
        position: absolute;
        content: '';
        width:100%;
        height:1px;
        background-color: #ccc;
        bottom: -10px;
        left: 0;
    }

    .form-search-product table{
        width: 100%;
        border: none;
    }

    .form-search-product table th{
        width: 100px;
    }

    .form-search-product .form-search-product-text{
        display: block;
        margin-right: 20px;
        font-family: "Open Sans",sans-serif;
        font-size: 15px;
        line-height: 1.8em;
        font-weight: 400;
        color: #8b8b8b;
    }

    .form-search-product .form-search-product-text-error{
        display: block;
        margin: 4px 0 4px 10px;
        font-family: "Open Sans",sans-serif;
        font-size: 12px;
        line-height: 1.8em;
        font-weight: 400;
        color: red;
    }

    .form-search-product .form-search-product-input-text{
        margin-bottom: 10px;
        display: block;
        width: 300px;
        padding: 6px 20px;
        font-family: "EB Garamond",serif;
        font-size: 16px;
        font-style: italic;
        line-height: 12px;
        font-weight: inherit;
        color: #8b8b8b;
        border: 1px solid #ddd;
        outline: 0;
        cursor: pointer;
    }

    .form-search-product .form-search-product-categories{
        width: 100%;
    }

    .form-search-product .form-search-product-categories-content{
        display: block;
        max-width: 35%;
        height: 120px;
        overflow: hidden;
        overflow-y: scroll;
    }


    .form-search-product .form-search-product-categories-item-item{
        padding: 10px 5px;
        display:flex;
        align-items: center;
        text-align: center;
        flex-direction: row;
        width: 200px;
    }


    .form-search-product .form-search-product-categories-item input{
        margin-left: 10px;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .form-search-product .form-search-product-categories-item label{
        margin: 0;
        display: block;
        padding-left: 10px;
        margin-left: 2px;
        font-family: "EB Garamond",serif;
        font-size: 16px;
        font-style: italic;
        line-height: 12px;
        font-weight: inherit;
        color: #8b8b8b;
        background-color: transparent;
        outline: 0;
        cursor: pointer;
    }

    .form-search-product .form-search-product-item{
        width: 100%;
        text-align: right;
    }

    .form-search-product .btn-search{
        padding: 3px 10px;
        background-color: transparent;
        border: 1px solid #8b8b8b;
        border-radius: 5px;
        font-style: italic;
        color: #1d1d1d;
        text-transform: capitalize;
    }

    .form-search-product .btn-search:hover{
        border: 1px solid #1d1d1d;
        color: #8b8b8b;
        transition: all 0.5s ease-in-out;
    }

    .btn-outline-primary{
        background-color: transparent;
        border: 1px solid #8b8b8b !important;
        font-family: "EB Garamond",serif;
        font-size: 16px !important;
        font-weight: 400;
        font-style: italic;
        color: #1d1d1d !important;
        height: 50px;
        min-width: 160px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
    }

    .btn-outline-primary:hover{
        background-color: #fff !important;
        border: 1px solid #1d1d1d !important;
        color: #8b8b8b !important;
        transition: all 0.5s ease-in;
    }
</style>
