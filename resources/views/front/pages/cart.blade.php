@extends('front.base')
@section('title', 'Giỏ hàng')

@section('content')
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
    <div class="cart content">
        <div class="cart-wrapper">
            <div class="cart-top">
                <span><a href="{{route('home')}}">Trang chủ</a></span>
                <span>-</span>
                <span>Giỏ Hàng</span>
            </div>
            @if(count($items)>0)
                <div class="cart-middle">
                    <div class="cart-middle-form">
                        <table class="cart-middle-table">
                            <thead class="cart-middle-table-title">
                            <tr class="cart-middle-table-products-item">
                                <td></td>
                                <td></td>
                                <td class="cart-middle-table-title-item">SẢN PHẨM</td>
                                <td class="cart-middle-table-title-item">GIÁ</td>
                                <td class="cart-middle-table-title-item">SỐ LƯỢNG</td>
                                <td class="cart-middle-table-title-item">TẠM TÍNH</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody class="cart-middle-table-products">
                            @foreach($items as $item)
                                <tr class="cart-middle-table-products-item">
                                    <td class="cart-middle-table-products-item-children">
                                        <label class="cart-middle-table-products-item-children-input">
                                            <input type="checkbox" class="btn-choose-cart-item" value="{{$item->id}}">
                                            <i class="fa-solid fa-check checkbox-item-icon"></i>
                                        </label>
                                        @if($item->product->discount)
                                            @php
                                                if ($item->product->discount->val <= 100) {
                                                    $priceDiscount = $item->product->price * (1 - $item->product->discount->val/100);
                                                } else {
                                                    $priceDiscount = $item->product->price - $item->product->discount->val;
                                                }
                                            @endphp
                                            <input type="hidden" value="{{$item->quantity * $priceDiscount}}"
                                                   id="cart-item-total-hidden-{{$item->id}}">
                                        @else
                                            <input type="hidden" value="{{$item->quantity * $item->product->price}}"
                                                   id="cart-item-total-hidden-{{$item->id}}">
                                        @endif
                                    </td>
                                    <td class="cart-middle-table-products-item-item-img cart-middle-table-products-item-children" >
                                        <img src="{{asset('products/'.$item->product->cover)}}" alt="" >
                                    </td>
                                    <td class="cart-middle-table-products-item-item cart-middle-table-products-item-children">
                                        <span class="cart-middle-table-products-item-item-text">{{mb_strtoupper($item->product->name)}}</span>
                                    </td>
                                    <td class="cart-middle-table-products-item-item cart-middle-table-products-item-children">
                                        @if($item->product->discount)
                                            <del class="cart-middle-table-products-item-item-price">
                                                <x-money :amount="$item->product->price" />
                                            </del>
                                            <p class="cart-middle-table-products-item-item-price">
                                                <x-money :amount="$priceDiscount" />
                                            </p>
                                        @else
                                            <p class="cart-middle-table-products-item-item-price">
                                                <x-money :amount="$item->product->price" />
                                            </p>
                                        @endif

                                    </td>
                                    <td class="cart-middle-table-products-item-item">
                                        <div class="product-detail-wrapper-top-right-quantity">
                                            <input type="hidden" name="_token" content="{{csrf_token()}}">
                                            <i class="fas fa-minus product-detail-wrapper-top-right-quantity-minus btnUpdate btn-minus" data-cartid="{{$item->id}}"></i>
                                            <input class="product-detail-wrapper-top-right-quantity-number product-detail-wrapper-top-right-btn-number" type="text" value="{{$item->quantity}}" style="width: 20px" id="cart-item-{{$item->id}}">
                                            <i class="fas fa-plus product-detail-wrapper-top-right-quantity-plus btnUpdate btn-plus" data-cartid="{{$item->id}}"></i>
                                        </div>
                                    </td>
                                    <td class="cart-middle-table-products-item-item cart-middle-table-products-item-children">
                                        @if($item->product->discount)
                                            <p class="cart-middle-table-products-item-item-price" id="cart-item-total-{{$item->id}}">
                                                <x-money :amount="$item->quantity * $priceDiscount" />
                                            </p>
                                        @else
                                            <p class="cart-middle-table-products-item-item-price" id="cart-item-total-{{$item->id}}">
                                                <x-money :amount="$item->quantity * $item->product->price" />
                                            </p>
                                        @endif
                                    </td>
                                    <td class="cart-middle-table-products-item-item">
                                        <form action="{{route('cart.destroy', [$item->id])}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="cart-middle-table-products-item-item-icon">
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhZH5gcR2G2KoE1tvK8nqGdU7YLDtCRbHJX0woD3kGB1_hFMViT0yAI9Y7Q1HXHMt14LM&usqp=CAU">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    @error('cartIds')
                    <span style="color:red;">{!! $message !!}</span>
                    @enderror
                </div>
                <div class="cart-bottom">
                    <h1 class="cart-bottom-title">TỔNG TIỀN</h1>
                    <div class="cart-bottom-total">
                        <span class="cart-bottom-total-text">Total</span>
                        <p class="cart-bottom-total-price" id="cart-total-price">0 ₫</p>
                    </div>
                    <form action="{{route('order.create')}}" method="post">
                        @csrf
                        <input type="hidden" name="cartIds" value="1" id="cardId-hidden">
                        <div class="cart-bottom-btn">
                            <button class="product-detail-wrapper-top-view-cart-btn" type="submit">Thanh toán</button>
                        </div>
                    </form>
                </div>
            @else
                <span>Không có sản phẩm nào trong giỏ hàng</span>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $(document).on('click', '.btnUpdate', function (){
                totalPrice = 0;
                $(".btn-choose-cart-item").prop('checked', false);
                $("#cart-total-price").html(totalPrice.toLocaleString("vi", {style:"currency", currency:"VND"}));
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').attr('content')
                    }
                })
                if($(this).hasClass('btn-minus')){
                    var quantity = $(this).next().val();
                    if(quantity >10) {
                        alert('Số lượng sản phẩm phải tối đa là 10');
                        return false;
                    }else if(quantity <=1) {
                        alert('Số lượng sản phẩm phải tối thiểu là 1');
                        return false;
                    }else{
                        new_qty = parseInt(quantity)-1;
                    }
                }
                if($(this).hasClass('btn-plus')){
                    var quantity = $(this).prev().val();
                    if(quantity <1) {
                        alert('Số lượng sản phẩm phải tối thiểu là 1');
                        return false;
                    }else if (quantity >=10) {
                        alert('Số lượng sản phẩm phải tối đa là 10');
                        return false;
                    } else {
                        new_qty = parseInt(quantity)+1;
                    }
                }

                var cartid = $(this).data('cartid');
                $.ajax({
                    data:{
                        "cartid":cartid,
                        "qty":new_qty
                    },
                    url: '{{route('cart.update')}}',
                    type: 'post',
                    success:function (response){
                        $("#cart-item-"+response.id).val(response.quantity);
                        $("#cart-item-total-"+response.id).html((response.quantity * response.price).toLocaleString("vi", {style:"currency", currency:"VND"}));
                        $("#cart-item-total-hidden-"+response.id).val(response.quantity * response.price);
                        $("#header-cart-quantity-"+response.id).html("Quantity: "+response.quantity);
                        $headerTotalPrice = 0;
                        $( ".btn-choose-cart-item" ).each(function() {
                            $headerTotalPrice = $headerTotalPrice + parseInt($('#cart-item-total-hidden-'+ $(this).val()).val());
                        });
                        $("#header-cart-total-price").html($headerTotalPrice.toLocaleString("vi", {style:"currency", currency:"VND"}));
                    },
                    error: function (){
                        alert("Error");
                    }
                })
            })
            var totalPrice = 0;
            let cartId = [];
            $(document).on('click', '.btn-choose-cart-item', function (){
                if($(this).is(":checked")){
                    cartId.push($(this).val());
                    totalPrice = totalPrice + parseInt($('#cart-item-total-hidden-'+ $(this).val()).val());
                } else {
                    totalPrice = totalPrice - parseInt($('#cart-item-total-hidden-'+ $(this).val()).val());
                    let cid = $(this).val();
                    cartId = $.grep(cartId, function(value) {
                        return value != cid;
                    });
                }
                $("#cart-total-price").html(totalPrice.toLocaleString("vi", {style:"currency", currency:"VND"}));
                $("#cardId-hidden").val("["+cartId.toString()+"]");
            })
        });
        </script>
@endsection
