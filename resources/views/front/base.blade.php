<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/front/css/home.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/product.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/productdetail.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/cart.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/checkout.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/sale.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/blog.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/intro.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/feedback.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/concept.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/design.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/components/grid.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/components/paginate.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/icons/font-awesome/css/fontawesome-all.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"
            integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
</head>
<body>
<div class="container">
    @include('front.components.header')

    @yield('content')

    @include('front.components.footer')

    <div class="header-menu">
        <div class="header-menu-close"  onclick="closeMenu()"></div>
        <div class="header-menu-wrapper">
            <div class="header-menu-wrapper-item">
                <a href="{{route('front.user.profile')}}">Thông tin cá nhân</a>
            </div>
            <div class="header-menu-wrapper-item">
                <a href="{{route('front.user.edit')}}">Sửa thông tin cá nhân</a>
            </div>
            <div class="header-menu-wrapper-item">
                <a href="{{route('front.user.order')}}">Đơn hàng của tôi</a>
            </div>
            <div class="header-menu-wrapper-item">
                <a href="{{route('front.user.order.success')}}">Đơn hàng đã giao</a>
            </div>
            <div class="header-menu-wrapper-item">
                <a href="{{route('auth.logout')}}">Đăng xuất</a>
            </div>
        </div>
    </div>

    <div class="header-cart">
        <div class="header-cart-close" onclick="closeCart()"></div>
        <div class="header-cart-wrapper">
            @if(count(\App\Helper\Common::getCartItems()))
                <div class="header-cart-wrapper-content">
                    <div class="header-cart-product">
                        <ul class="header-cart-product-wrapper">
                            @php
                                $total = 0;
                                $items = \App\Helper\Common::getCartItems();
                            @endphp
                            @foreach($items as $item)
                                @php
                                    $price = $item->product->price;
									if ($item->product->discount) {
										if ($item->product->discount->val < 100) {
                                            $price = $price * (1 - $item->product->discount->val/100);
                                        } else {
                                            $price = $price - $item->product->discount->val;
                                        }
									}
                                    $total = $total + $item->quantity * $price;
								@endphp
                                <li class="header-cart-product-wrapper-item">
                                    <img src="{{asset('products/'.$item->product->cover)}}" alt="">
                                    <div class="header-cart-product-wrapper-item-information">
                                        <span class="header-cart-product-wrapper-item-information-text">{{mb_strtoupper($item->product->name)}}</span>
                                        <p class="header-cart-product-wrapper-item-information-quantity" id="header-cart-quantity-{{$item->id}}">
                                            Quantity: {{$item->quantity}}</p>
                                        <p class="header-cart-product-wrapper-item-information-price">
                                            <x-money :amount="$price" />
                                        </p>
                                    </div>
                                    <form action="{{route('cart.destroy', [$item->id])}}" method="post" style="display:flex; align-items: center;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="cart-middle-table-products-item-item-icon">
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRhZH5gcR2G2KoE1tvK8nqGdU7YLDtCRbHJX0woD3kGB1_hFMViT0yAI9Y7Q1HXHMt14LM&amp;usqp=CAU">
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="header-cart-price">
                        <span class="header-cart-price-text">Total</span>
                        <p class="header-cart-price-price" id="header-cart-total-price">
                            <x-money :amount="$total" />
                        </p>
                    </div>
                    <div class="header-cart-btn">
                        <a class="header-cart-btn-view-cart" href="{{route('cart')}}">Giỏ hàng</a>
                        <form action="{{route('order.create')}}" method="post">
                            @csrf
                            <input type="hidden" name="cartIds" value="{{json_encode($items->pluck('id')->toArray())}}">
                            <button class="header-cart-btn-view-checkout" type="submit">Thanh toán</button>
                        </form>
                    </div>
                </div>
            @else
                <span class="header-cart-wrapper-no-product">
                    <a>Không có sản phẩm nào trong giỏ hàng</a>
                </span>
            @endif
        </div>
    </div>
</div>
</body>

{{--<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css">--}}
<script>
    var botmanWidget = {
        title: 'HomeFurniture Bot',
        aboutText: 'HomeFurniture',
        aboutLink: '{{route('home')}}',
        introMessage: '✋ Hi! Cảm ơn bạn đã ghé thăm cửa hàng của chúng tôi. Hãy nhập vào "Tôi cần sự trợ giúp" để được tư vấn'
    };
</script>

<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

<script>
    let slideIndex = 0;
    showSlide(slideIndex);

    showSlide();

    function showSlide() {
        let i;
        var imgs = document.getElementsByClassName("slide-images-item");
        for( i = 0 ; i < imgs.length ; i++){
            imgs[i].style.display = 'none';
        }
        slideIndex++;
        if(slideIndex > imgs.length){
            slideIndex = 1;
        }
        if(slideIndex < 1){
            slideIndex = imgs.length
        }

        imgs[slideIndex - 1].style.display = 'block';

        setTimeout(showSlide, 3000);
    }
</script>
</html>
