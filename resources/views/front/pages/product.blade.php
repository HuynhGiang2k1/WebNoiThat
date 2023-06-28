@extends('front.base')
@section('title', 'Danh sách sản phẩm')

@section('content')
    <div class="product content">
        <div class="product-img">
            <img src="{{asset('banner/Copy-of-DECOR-MORE.png')}}" alt="">
        </div>
        <div class="product-content">
            <div class="product-content-wrapper">
                <div class="product-content-wrapper-left">
                    <div class="product-content-wrapper-left-search">
                        <form action="{{route('front.product.search')}}">
                            <button type="submit"><i class="fas fa-search"></i></button>
                            <input type="text" placeholder="Tìm kiếm" name="search">
                        </form>
                    </div>
                    <div class="product-content-wrapper-left-category">
                        <span class="product-content-wrapper-left-category-text">Danh mục</span>
                        @foreach($categories as $category)
                            <ul class="product-content-wrapper-left-category-content-item">
                                <a href="{{route('front.products', [$category->name_en])}}" class="product-content-wrapper-left-category-content-item-text">{{$category->name}}</a>
                                @foreach($category->subcategories as $subcategory)
                                    <li class="product-content-wrapper-left-category-content-item-item">
                                        <a href="{{route('front.products',[$category->name_en, $subcategory->name_en])}}">{{$subcategory->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>

                <div class="product-content-wrapper-right">
                    <ul class="product-content-wrapper-right-content grid row">
                        @foreach($products as $product)
                            <li class="product-content-wrapper-right-content-item c-3 c-o-o ">
                                <a href="{{route('front.product.show', [$product->id])}}" class="product-content-wrapper-right-content-item-icon">
                                    <img class="product-content-wrapper-right-content-item-img" src="{{asset('products/'.$product->cover)}}" alt="">
                                    <i class="fa-solid fa-cart-shopping product-content-wrapper-right-content-item-icon-icon"></i>
                                </a>
                                <p class="product-content-wrapper-right-content-item-text">{{$product->name}}</p>
                                @if($product->discount)
                                    <del class="product-content-wrapper-right-content-item-price">
                                        <x-money :amount="$product->price" />
                                    </del>
                                    <span class="product-content-wrapper-right-content-item-price">
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
                            </li>
                        @endforeach
                            {{ $products->links() }}
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
