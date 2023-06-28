@extends('front.base')
@section('title', 'Trang chủ')
@section('content')
    <div class="content">
        <div class="content-slider-img">
            <div class="slide-images-content">
                <a href="#"><img src="{{asset('sliders/ban-hoc-1300x650.jpg')}}" class="slide-images-item"/></a>
                <a href="#"><img src="{{asset('sliders/banner-1300x650.jpg')}}" class="slide-images-item"/></a>
                <a href="#"><img src="{{asset('sliders/sofa-1300x650.jpg')}}" class="slide-images-item"/></a>
            </div>
        </div>
        <div class="content-options-static ">
            <div class="content-options-static-content">
                <div class="content-options-static-content-item">
                    <img src="{{asset('banner/1.png')}}" alt="">
                    <div class="content-options-static-content-item-text">
                        <p>Sale Off</p>
                        <a href="{{route('front.product.sale')}}">Xem Ngay</a>
                    </div >
                </div>
                <div class="content-options-static-content-item">
                    <img src="{{asset('banner/3.png')}}" alt="">
                    <div class="content-options-static-content-item-text">
                        <p>Feedback</p>
                        <a href="{{route('feedback')}}">Xem Ngay</a>
                    </div>
                </div>
                <div class="content-options-static-content-item">
                    <img src="{{asset('banner/2-1.png')}}" alt="">
                    <div class="content-options-static-content-item-text">
                        <p>Thiết Kế</p>
                        <a href="{{route('design')}}">Shop Now</a>
                    </div>
                </div>
                <div class="content-options-static-content-item">
                    <img src="{{asset('banner/IMG_1508-1477x1536.jpg')}}" alt="">
                    <div class="content-options-static-content-item-text">
                        <p>Concept</p>
                        <a href="{{route('concept')}}">Xem Ngay</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-options-dynamic">
            <div class="content-options-dynamic-item">
                <img src="{{asset('banner/3-1.png')}}" alt="">
            </div>
            <div class="content-options-dynamic-item">
                <img src="{{asset('banner/3-2.png')}}" alt="">
            </div>
            <div class="content-options-dynamic-item">
                <img src="{{asset('banner/3-3.png')}}" alt="">
            </div>
        </div>
        <div class="content-introduce">
            <div class="content-introduce-text">
                <i>"We shape our home and then our home shapes us"</i>
                <div class="content-introduce-text-item">
                    <img src="{{asset('banner/Copy-of-DECOR-MORE.png')}}" alt="">
                    <p>HomeFurniture Team with love</p>
                </div>
            </div>
            <ul>
                    <span>
                        Kiến thức nội thất
                    </span>
                <li><a href="#">Bí quyết vệ sinh, bảo quản nội thất gỗ công nghiệp</a></li>
                <li><a href="#">5 lời khuyên cho bàn làm việc hoàn hảo tại nhà</a></li>
                <li><a href="#">Mẹo bố trí phòng ngủ để đêm ngon giấc</a></li>
                <li><a href="#">Phân biệt các loại gỗ công nghiệp</a></li>
                <li><a href="#">Tại sao gỗ sồi được yêu thích ở các nước âu mỹ</a></li>
            </ul>
        </div>
    </div>
@endsection
