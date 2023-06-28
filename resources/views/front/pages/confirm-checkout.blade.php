@extends('front.base')
@section('title', 'Thông tin thanh toán')

@section('content')
    <div class="checkout content">
        <div class="checkout-wrapper">

            <div class="checkout-information">
                <form class="checkout-information-form" method="post" action="{{route('order.store')}}" id="my-form">
                    @csrf
                    <input type="hidden" name="cartIds" value="{{json_encode($items->modelKeys())}}">
                    <div class="checkout-information-form-bottom">
                        <h1 class="checkout-information-form-bottom-title">Xác nhận thông tin</h1>
                        <table class="checkout-information-form-bottom-table">
                            <thead>
                            <tr>
                                <th class="checkout-information-form-bottom-table-left">Tên sản phẩm</th>
                                <th class="checkout-information-form-bottom-table-mid">Giá</th>
                                <th class="checkout-information-form-bottom-table-right">Tạm tính</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $totalPrice = 0 @endphp
                            @foreach($items as $item)
                                <tr>
                                    <td class="checkout-information-form-bottom-table-left">{{$item->product->name}} ({{$item->quantity}})</td>
                                    <td class="checkout-information-form-bottom-table-left">
                                        @php $price = $item->product->price; $subtotal = 0; @endphp
                                        @if($item->product->discount)
                                            @php
                                                if ($item->product->discount->val <= 100) {
                                                    $price = $price * (1 - $item->product->discount->val/100);
                                                } else {
                                                    $price = $price - $item->product->discount->val;
                                                }
                                            @endphp
                                            <del class="cart-middle-table-products-item-item-price">
                                                <x-money :amount="$item->product->price" />
                                            </del>
                                            <p>
                                                <x-money :amount="$price" />
                                            </p>
                                        @else
                                            <x-money :amount="$price" />
                                        @endif
                                        @php
                                            $subtotal = $item->quantity * $price;
                                            $totalPrice += $subtotal;
                                        @endphp
                                    </td>
                                    <td class="checkout-information-form-bottom-table-right">
                                        <x-money :amount="$subtotal" />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="checkout-information-form-bottom-table-left">Tổng tiền</th>
                                <td class="checkout-information-form-bottom-table-right">
                                    <x-money :amount="$totalPrice" />
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                        <div class="checkout-information-form-bottom-information">
                            <h4 class="checkout-information-form-bottom-information-title">
                                <i class=" fas fa-map-marker-alt"></i>
                                Địa chỉ nhận hàng:
                            </h4>
                            <div class="checkout-information-form-bottom-information-personal">
                                <span>{{$request->name}}</span>
                                <span> | </span>
                                <span>{{$request->phone}}</span>
                            </div>
                            <div class="checkout-information-form-bottom-information-address">
                                <span>{{$request->street}}, </span>
                                <span id="ward"></span>
                                <span id="district"></span>
                                <span id="province"></span>
                            </div>
                            <input type="hidden" name="street" id="street" value="{{$request->street}}">
                            <input type="hidden" name="ward" id="ward-hidden">
                            <input type="hidden" name="district" id="district-hidden">
                            <input type="hidden" name="province" id="province-hidden">
                            <input type="hidden" name="payOption" value="{{$request->payOption}}">
                            <input type="hidden" name="email" value="{{$request->email}}">
                            <input type="hidden" name="name" value="{{$request->name}}">
                            <input type="hidden" name="orderNotes" value="{{$request->orderNotes}}">
                            <input type="hidden" name="phone" value="{{$request->phone}}">
                        </div>
                    </div>
                    <div class="checkout-information-btn"><button type="submit">Tiếp tục thanh toán</button></div>
                </form>
                <div class="wrapper-link-hover" style="margin-top: 28px; width: max-content;">
                    <a href="{{route('cart')}}" class="link-hover link-page-checkout">Trở về trang giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Load provinces
            $.getJSON('https://vapi.vnappmob.com/api/province', function(provinces) {
                $.each(provinces.results, function(i, province) {
                    if(province.province_id == {{$request->province}}) {
                        $("#province-hidden").val(province.province_name);
                        $('#province').html(province.province_name);
                    }
                });
            });

            // Load districts
            $.getJSON('https://vapi.vnappmob.com/api/province/district/' + {{$request->province}}, function(districts) {
                $.each(districts.results, function(i, district) {
                    if(district.district_id == {{$request->district}}) {
                        $("#district-hidden").val(district.district_name);
                        $('#district').html(district.district_name + ', ');
                    }
                });
            });

            // Load wards
            $.getJSON('https://vapi.vnappmob.com/api/province/ward/' + {{$request->district}} , function(wards) {
                $.each(wards.results, function(i, ward) {
                    if(ward.ward_id == {{$request->ward}}) {
                        $("#ward-hidden").val(ward.ward_name);
                        $('#ward').html(ward.ward_name + ', ');
                    }
                });
            });
        });
    </script>
@endsection
