<x-mail::message>
    <p>Xin chào {{$data['order']->user_name}}</p>
    <p>Đơn hàng #{{$data['order']->id}} của bạn đã được giao thành công ngày {{$data['order']->verified_at }}.</p>
    <p>Vui lòng đăng nhập HomeFurniture để xác nhận bạn đã nhận hàng</p>



<x-mail::button :url="route('front.user.order')">
    Đơn hàng của tôi
</x-mail::button>
    <hr>
    <h4>THÔNG TIN ĐƠN HÀNG</h4>
    <table cellspacing="0" cellpadding="0" border="0" style="text-align: left" width="600">
        <tr>
            <th>Mã đơn hàng:</th>
            <td>{{$data['order']->id}}</td>
        </tr>
        <tr>
            <th>Ngày đặt hàng:</th>
            <td>{{$data['order']->created_at}}</td>
        </tr>
    </table>
    @foreach(json_decode($data['order']->product_id) as $key => $productInfo)
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
        <br>{{($key+1).'. '.$product->name}}<br>
        <table cellspacing="0" cellpadding="0" border="0" style="text-align: left" width="600">
            <tr>
                <th>Số lượng:</th>
                <td>{{$productInfo[2]}}</td>
            </tr>
            <tr>
                <th>Giá:</th>
                <td>
                    @if($productInfo[3])
                        <del><x-money :amount="$productInfo[1]" /></del><br>
                        <x-money :amount="$price" />
                    @else
                        <x-money :amount="$productInfo[1]" />
                    @endif
                </td>
            </tr>
        </table>
    @endforeach
    <hr>
    <table cellspacing="0" cellpadding="0" border="0" style="text-align: left; margin-bottom: 50px;" width="600" >
        <tr>
            <th>Tổng tiền:</th>
            <td><x-money :amount="$data['order']->money" /></td>
        </tr>
        <tr>
            <th>Phí vận chuyển:</th>
            <td><x-money :amount="$data['order']->shipping_fee" /></td>
        </tr>
        <tr>
            <th>Tổng thanh toán:</th>
            <td><x-money :amount="$data['order']->money + $data['order']->shipping_fee" /></td>
        </tr>
    </table>


Trân trọng,<br>
Đội ngũ HomeFurniture
</x-mail::message>
