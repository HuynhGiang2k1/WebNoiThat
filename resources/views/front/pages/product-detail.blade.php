@extends('front.base')
@section('title', $product->name.' - HomeFurniture')

@section('content')
    <div class="product-detail content">
        <div class="product-img">
            <img src="{{asset('banner/Copy-of-DECOR-MORE.png')}}" alt="">
        </div>
        <div class="product-detail-wrapper">
            @if(session('success'))
            <div class="product-detail-wrapper-top-view-cart">
                <span class="product-detail-wrapper-top-view-cart-text">{{mb_strtoupper($product->name)}} đã được thêm vào giỏ hàng</span>
                <a class="product-detail-wrapper-top-view-cart-btn" href="{{route('cart')}}">Đi đến giỏ hàng</a>
            </div>
            @endif
            <div class="product-detail-wrapper-top">
                <div class="wrapper-img-detail">
                    <div class="wrapper-img-detail-sub">
                        @foreach($product->images as $img)
                            <img src="{{asset('products/'.$img->name)}}" alt="" class="image-thumbnail">
                        @endforeach
                    </div>
                    <div class="product-detail-wrapper-top-left">
                        <img src="{{asset('products/'.$product->cover)}}" alt="" id="main-image">
                    </div>
                </div>
                <div class="product-detail-wrapper-top-right">
                    <h1 class="product-detail-wrapper-top-right-text">{{mb_strtoupper($product->name)}}</h1>
                    <p class="product-detail-wrapper-top-right-price">
                        <x-money :amount="$product->price" />
                    </p>
                    <span class="product-detail-wrapper-top-right-information">{{$product->size}}</span>
                    <span class="product-detail-wrapper-top-right-information">{{$product->description}}</span>
                    <form action="{{route('cart.create')}}" method="post">
                        @csrf
                        <input type="hidden" name="pid" value="{{$product->id}}">
                        <div class="product-detail-wrapper-top-right-btn">
                            <div class="product-detail-wrapper-top-right-quantity">
                                <div class="minus-btn">
                                    <i class="fas fa-minus product-detail-wrapper-top-right-quantity-minus"></i>
                                </div>
                                <input class="product-detail-wrapper-top-right-btn-number" type="text" value="1" name="quantity" style="width: 20px">
                                <div class="plus-btn">
                                    <i class="fas fa-plus product-detail-wrapper-top-right-quantity-plus"></i>
                                </div>
                            </div>
                            <button class="product-detail-wrapper-top-right-btn-add" type="submit">Thêm vào giỏ hàng</button>
                        </div>
                        @if(session('errors')==999)
                            <span style="color: red;">Chỉ được mua số lượng tối đa là {{config('hf.cart.purchase_limit')}}</span>
                        @elseif(session('errors'))
                            <span style="color: red;">Chỉ được mua số lượng tối đa là {{config('hf.cart.purchase_limit')}}.
                                Hiện tại trong giỏ hàng của bạn đã có {{session('errors')}}</span>
                        @endif
                    </form>
                    <div class="product-detail-wrapper-top-right-category">
                        <p class="product-detail-wrapper-top-right-category-text">Danh mục :</p>
                        <span class="product-detail-wrapper-top-right-category-item">
                            @php
                                foreach ($product->categories as $cate) {
                                    echo $cate->name.", ";
                                }
                                foreach ($product->subcategories as $sub) {
                                    echo $sub->name.", ";
                                }
                            @endphp
                        </span>
                    </div>
                </div>
            </div>

            <div class="product-detail-wrapper-middle">
                <div class="product-detail-wrapper-middle-wrapper">
                    <p class="product-detail-wrapper-middle-text">THÔNG TIN THÊM</p>
                </div>
                <p class="product-detail-wrapper-middle-text">KÍCH THƯỚC</p>
                <span class="product-detail-wrapper-middle-size">{{$product->size}}</span>
            </div>

            @if(count($relatedProducts) > 0)
                <div class="product-detail-wrapper-bottom">
                    <h1 class="product-detail-wrapper-bottom-text">SẢN PHẨM TƯƠNG TỰ</h1>
                    <ul class="product-content-wrapper-right-content grid row">
                        @foreach($relatedProducts as $relatedProduct)
                            <li class="product-content-wrapper-right-content-item c-3">
                                <a href="{{route('front.product.show', [$relatedProduct->id])}}"
                                   class="product-content-wrapper-right-content-item-icon">
                                    <img class="product-content-wrapper-right-content-item-img" src="{{asset('products/'.$relatedProduct->cover)}}" alt="">
                                    <i class="fa-solid fa-cart-shopping product-content-wrapper-right-content-item-icon-icon"></i>
                                </a>
                                <p class="product-content-wrapper-right-content-item-text">{{$relatedProduct->name}}</p>
                                <span class="product-content-wrapper-right-content-item-price">
                                    <x-money :amount="$relatedProduct->price" />
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    <script>
        var plusBtn = document.querySelectorAll(".plus-btn");

        plusBtn.forEach(function(btn) {
            btn.addEventListener("click", function() {
                var quantityInput = btn.previousElementSibling;
                if (parseInt(quantityInput.value) < 10) {
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                }
            });
        });

        var minusBtn = document.querySelectorAll(".minus-btn");

        minusBtn.forEach(function(btn) {
            btn.addEventListener("click", function() {
                var quantityInput = btn.nextElementSibling;
                if (parseInt(quantityInput.value) > 1) {
                    quantityInput.value = parseInt(quantityInput.value) - 1;
                }
            });
        });

        var thumbnails = document.querySelectorAll('.image-thumbnail');

        // Lặp qua từng thumbnail và thêm sự kiện "click"
        thumbnails.forEach(function(thumbnail) {
            thumbnail.addEventListener('click', function() {
                // Lấy đường dẫn hình ảnh từ thuộc tính "src" của thumbnail được nhấp
                var imagePath = thumbnail.getAttribute('src');

                // Cập nhật hình ảnh chính
                var mainImage = document.getElementById('main-image');
                var mainPath = mainImage.getAttribute('src');
                mainImage.setAttribute('src', imagePath);
                thumbnail.setAttribute('src', mainPath);
            });
        });

    </script>
@endsection
