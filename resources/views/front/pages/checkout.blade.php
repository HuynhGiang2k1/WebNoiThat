@extends('front.base')
@section('title', 'Thông tin thanh toán')

@section('content')
    @php
        $user = \Auth::user();
        if (!$user->address) {
            $address = explode('-', '-0-0-0');
        } else {
            $address = explode('-', $user->address);
        }
    @endphp
    <div class="checkout content">
        <div class="checkout-wrapper">

            <div class="checkout-information">
                <form class="checkout-information-form" method="post" action="{{route('order.confirm')}}" id="my-form">
                    @csrf
                    <div class="checkout-information-form-top">
                        <div class="checkout-information-form-item">
                            <h1>Chi tiết thanh toán</h1>
                            <div class="checkout-information-form-item-content">
                                <label for="pay-full-name" class="checkout-information-form-item-content-input-label">Họ tên *</label>
                                <input type="text" name="name" id="pay-full-name" class="checkout-information-form-item-content-input" value="{{$user->name}}">
                            </div>
                            <div class="checkout-information-form-item-content">
                                <label class="checkout-information-form-item-content-input-label">Quốc gia *</label>
                                <span class="checkout-information-form-item-content-span">Vietnam</span>
                            </div>
                            <div class="checkout-information-form-item-content">
                                <label for="province" class="checkout-information-form-item-content-input-label">Tỉnh/ Thành phố *</label>
                                <select id="province" name="province" class="checkout-information-form-item-content-input"></select>
                            </div>
                            <div class="checkout-information-form-item-content">
                                <label for="district" class="checkout-information-form-item-content-input-label">Quận/ Huyện *</label>
                                <select id="district" name="district" class="checkout-information-form-item-content-input"></select>
                            </div>
                            <div class="checkout-information-form-item-content">
                                <label for="ward" class="checkout-information-form-item-content-input-label">Phường/ Xã *</label>
                                <select id="ward" name="ward" class="checkout-information-form-item-content-input"></select>
                            </div>
                            <div class="checkout-information-form-item-content">
                                <label for="street" class="checkout-information-form-item-content-input-label">Tên đường/ Tòa nhà *</label>
                                <input type="text" name="street" id="street" class="checkout-information-form-item-content-input"
                                       value="{{$address[0]}}">
                            </div>
                            <div class="checkout-information-form-item-content">
                                <label for="pay-phone" class="checkout-information-form-item-content-input-label">Số điện thoại *</label>
                                <input type="text" name="phone" id="pay-phone" class="checkout-information-form-item-content-input" value="{{$user->tel}}">
                            </div>
                            <div class="checkout-information-form-item-content">
                                <label for="pay-email" class="checkout-information-form-item-content-input-label">Email *</label>
                                <input type="text" name="email" id="pay-email" class="checkout-information-form-item-content-input" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="checkout-information-form-item">
                            <h1>Thông tin thêm</h1>
                            <div class="checkout-information-form-item-content">
                                <label for="pay-order-notes" class="checkout-information-form-item-content-input-label">Ghi chú đặt hàng</label>
                                <textarea name="orderNotes" id="pay-order-notes"
                                          placeholder="Notes about your order, e.g.special notes for delivery">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="cartIds" value="{{json_encode($items->modelKeys())}}">
                    <div class="checkout-information-form-bottom">
                        <h1 class="checkout-information-form-bottom-title">Thông tin đơn hàng</h1>
                        <table class="checkout-information-form-bottom-table">
                            <thead>
                            <tr>
                                <th class="checkout-information-form-bottom-table-left">Tên sản phẩm</th>
                                <th class="checkout-information-form-bottom-table-right">Giá</th>
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
                        <div class="checkout-information-form-bottom-options">
                            <div class="checkout-information-form-bottom-options-item">
                                <input type="radio" name="payOption" id="pay-options-onl" checked value="1">
                                <label for="pay-options-onl">Thanh toán qua VNPAY
                                    <img style="width: 80px" src="https://vnpay.vn/_nuxt/img/logo-primary.55e9c8c.svg">
                                    <div>
                                        Thực hiện thanh toán qua VNPAY. Bạn sẽ được miễn phí giao hàng
                                        <img style="width: 50px" src="{{asset('logo/freeship.webp')}}">
                                    </div>
                                </label>
                            </div>
                            <div class="checkout-information-form-bottom-options-item">
                                <input type="radio" name="payOption" id="pay-options-off" value="0">
                                <label for="pay-options-off">Trả tiền mặt khi nhận hàng (Phí vận chuyển 100.000 ₫)</label>
                            </div>
                            <span>Sau khi hoàn tất các mục yêu cầu trên, hãy chọn "Tiếp tục thanh toán" để hoàn tất thanh toán</span>
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
    <style>
        .error{
    padding-top: 9px;
    padding-left: 10px;
    font-size: 15px;
    color: red;
    font-style: italic;
    letter-spacing: 0.5px;
}
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            // Load provinces
            $.getJSON('https://vapi.vnappmob.com/api/province', function(provinces) {
                $.each(provinces.results, function(i, province) {
                    if (province.province_id == {{$address[3]}}) {
                        $('#province').append($('<option>', {
                            value: province.province_id,
                            text: province.province_name
                        }));
                    }
                });
            });

            // Load districts
            $.getJSON('https://vapi.vnappmob.com/api/province/district/' + {{$address[3]}}, function(districts) {
                $.each(districts.results, function(i, district) {
                    if (district.district_id == {{$address[2]}}) {
                        $('#district').append($('<option>', {
                            value: district.district_id,
                            text: district.district_name
                        }));
                    }
                });
            });

            // Load wards
            $.getJSON('https://vapi.vnappmob.com/api/province/ward/' + {{$address[2]}} , function(wards) {
                $.each(wards.results, function(i, ward) {
                    if (ward.ward_id == {{$address[1]}}) {
                        $('#ward').append($('<option>', {
                            value: ward.ward_id,
                            text: ward.ward_name
                        }));
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Load provinces
            $.getJSON('https://vapi.vnappmob.com/api/province', function(provinces) {
                $.each(provinces.results, function(i, province) {
                    $('#province').append($('<option>', {
                        value: province.province_id,
                        text: province.province_name
                    }));
                });
            });

            // Load districts
            $('#province').change(function() {
                var province_id = $('#province').val();
                $('#district').empty();
                $('#ward').empty();
                $.getJSON('https://vapi.vnappmob.com/api/province/district/' + province_id, function(districts) {
                    $.each(districts.results, function(i, district) {
                        $('#district').append($('<option>', {
                            value: district.district_id,
                            text: district.district_name
                        }));
                    });
                });
            });

            // Load wards
            $('#district').change(function() {
                var province_id = $('#province').val();
                var district_id = $('#district').val();
                $('#ward').empty();
                $.getJSON('https://vapi.vnappmob.com/api/province/ward/' + district_id , function(wards) {
                    $.each(wards.results, function(i, ward) {
                        $('#ward').append($('<option>', {
                            value: ward.ward_id,
                            text: ward.ward_name
                        }));
                    });
                });
            });

            $.validator.addMethod("validatePhone", function (value, element) {
                var phoneNumberPattern = /(84|\+84|0)(3[2-9]|5[6|8|9]|7[0|6|7|8|9]|8[1|2|3|4|5]|9[0|3|4|5|7|8])+([0-9]{7})\b/;
                return this.optional(element) || phoneNumberPattern.test(value);
            }, "Số điện thoại không hợp lệ");

            $("#my-form").validate({
                rules: {
                    "name": {
                        required: true,
                        minlength: 5
                    },
                    "province": {
                        required: true,
                    },
                    "district": {
                        required: true,
                    },
                    "ward": {
                        required: true,
                    },
                    "street": {
                        required: true,
                    },
                    "phone": {
                        required: true,
                        validatePhone: true
                    },
                    "email": {
                        required: true,
                        email: true,
                    },
                },

                messages: {
                    "name": {
                        required: "Họ và tên người nhận chưa được nhập",
                        minlength: "Hãy nhập tối đa 5 ký tự"
                    },
                    "province": {
                        required: "Vui lòng chọn Tỉnh/ Thành phố",
                    },
                    "district": {
                        required: "Vui lòng chọn Quận/ huyện",
                    },
                    "ward": {
                        required: "Vui lòng chọn Phường/ Xã",
                    },
                    "street": {
                        required: "Vui lòng nhập số nhà",
                    },
                    "phone": {
                        required: "Vui lòng nhập số điện thoại",
                        minlength: "Hãy nhập tối đa 11 ký tự"
                    },
                    "email": {
                        required: "Email người nhận chưa được nhập",
                        email: "Địa chỉ email không hợp lệ"
                    },
                }
            });
        });
    </script>
@endsection
