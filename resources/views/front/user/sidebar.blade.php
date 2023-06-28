@extends('front.base')

@section('content')
    <div class="content product-content">
        <div class="product-content-wrapper " style="margin-top: 10px;">
            <!-- <div class="sidebar">
                <div class="sidebar-item">
                    <a href="{{route('front.user.profile')}}">Thông tin cá nhân</a>
                </div>
                <div class="sidebar-item">
                    <a href="{{route('front.user.edit')}}">Sửa thông tin cá nhân</a>
                </div>
                <div class="sidebar-item">
                    <a href="{{route('front.user.order')}}">Đơn hàng của tôi</a>
                </div>
            </div> -->
            <div>
                @yield('myPageContent')
            </div>
        </div>
    </div> 
    <style>
        .sidebar .sidebar-item a{
            font-family: "Open Sans",sans-serif;
            font-size: 17px;
            line-height: 1.8em;
            font-weight: 400;
            color: #8b8b8b;
            margin-left: 20px;
            transition: all 1s ease;
        }

        .sidebar .sidebar-item a:hover{
            color: #1d1d1d;
        }
    </style>
@endsection
