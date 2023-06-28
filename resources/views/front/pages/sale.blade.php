@extends('front.base')
@section('title', 'Sản phẩm khuyến mãi')
@section('content')
    <div class="sale content">
        <div class="sale-wrapper">
            <div class="sale-top">
                <span><a href="{{route('home')}}">Trang chủ</a></span>
                <span>-</span>
                <span>SALE OFF</span>
            </div>
            <div class="sale-wrapper-content grid wide">
                <ul class="sale-wrapper-content-product">
                    @foreach($products as $product)
                        <li class="sale-wrapper-content-product-content col m-6 c-12 l-3">
                            <a href="{{route('front.product.show', [$product->id])}}">
                                <div class="sale-wrapper-content-product-item">
                                    <div class="sale-wrapper-content-product-item-icon">
                                        <img class="sale-wrapper-content-product-item-img" src="{{asset('products/'.$product->cover)}}" alt="">
                                        <i class="fa-solid fa-cart-shopping sale-wrapper-content-product-item-icon-icon"></i>
                                    </div>
                                    <p class="sale-wrapper-content-product-item-text">{{$product->name}}</p>
                                    <p class="sale-wrapper-content-product-item-category">Giường - Giường gỗ công nghiệp</p>
                                    <span class="sale-wrapper-content-product-item-price">
                                    @if($product->discount)
                                            <del class="product-content-wrapper-right-content-item-price">
                                        <x-money :amount="$product->price" />
                                    </del>
                                            <span class="product-content-wrapper-right-content-item-price"><br>
                                        @php
                                            if ($product->discount->val <= 100) {
                                                $priceDiscount = $product->price * (1 - $product->discount->val/100);
                                            } else {
                                                $priceDiscount = $product->price - $product->discount->val;
                                            }
                                        @endphp
                                        <x-money :amount="$priceDiscount" />
                                    </span>
                                        @else
                                            <span class="product-content-wrapper-right-content-item-price">
                                        <x-money :amount="$product->price" />
                                    </span>
                                        @endif
                                </span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
