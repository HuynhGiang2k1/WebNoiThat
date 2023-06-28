@php
    $categories = \App\Helper\Common::getCategories();
@endphp

<div class="header">
    <div class="header-item">
        <div class="header-logo">
            <a href="{{route('home')}}">
                <img src="{{asset('logo/logo3.jpg')}}" alt="">
            </a>
        </div>
        <div class="header-options">
            <div class="header-options-item">
                <a href="{{route('intro')}}" class="header-options-item-item">Giới thiệu</a>
            </div>

            <div class="header-options-item">
                <a href="{{route('front.products')}}" class="header-options-item-item">Danh mục sản phẩm</a>
                <div class="header-options-item-child">
                    <div class="header-options-item-child-wrap">
                        <ul class="header-options-item-child-menu">
                            @foreach($categories as $category)
                                @if(!in_array($category->name_en, ['bo-suu-tap', 'trang-tri']))
                                    <li class="header-options-item-child-menu-item">
                                        <a href="{{route('front.products', [$category->name_en])}}">{{$category->name}}</a>
                                        <ul class="header-options-item-child-menu-item-menu">
                                                @foreach($category->subcategories as $subcategory)
                                                <li>
                                                    <a href="{{route('front.products', [$category->name_en, $subcategory->name_en])}}">
                                                        {{$subcategory->name}}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="header-options-item">
                @if($categories->firstWhere('name_en', 'trang-tri'))
                    <a href="{{route('front.products', ['trang-tri'])}}" class="header-options-item-item">Trang trí và gia dụng</a>
                    @if(count($categories->firstWhere('name_en', 'trang-tri')->subcategories) > 0)
                        <div class="header-options-item-child" >
                            <ul class="header-options-item-child-menu-item-menu header-options-item-child-menu-item-menu-sub">
                                @foreach($categories->firstWhere('name_en', 'trang-tri')->subcategories as $subCategory)
                                    <li>
                                        <a href="{{route('front.products', ['trang-tri', $subCategory->name_en])}}">{{$subCategory->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @else
                    <span class="header-options-item-item">Trang trí và gia dụng</span>
                @endif
            </div>
            <div class="header-options-item">
                @if($categories->firstWhere('name_en', 'bo-suu-tap'))
                    <a href="{{route('front.products', ['bo-suu-tap'])}}" class="header-options-item-item">Bộ sưu tập</a>
                    @if(count($categories->firstWhere('name_en', 'bo-suu-tap')->subcategories) > 0)
                        <div class="header-options-item-child" >
                            <ul class="header-options-item-child-menu-item-menu header-options-item-child-menu-item-menu-sub">
                                @foreach($categories->firstWhere('name_en', 'bo-suu-tap')->subcategories as $subCategory)
                                    <li>
                                        <a href="{{route('front.products', ['bo-suu-tap', $subCategory->name_en])}}">
                                            {{$subCategory->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @else
                    <span class="header-options-item-item">Bộ sưu tập</span>
                @endif
            </div>
            <div class="header-options-item">
                <a href="{{route('blog')}}" class="header-options-item-item">Blog</a>
            </div>
        </div>
    </div>
    <div class="header-icons">
        @if(\Auth::user())
            <div class="header-icons-item" onclick="openCart()">
                <i class="fas fa-box-open"></i>
                <p>{{\App\Helper\Common::countCartItem()}}</p>
            </div>
            <div class="header-icons-item header-icons-item-hide" onclick="openMenu()">
                <span><i class="fas fa-user-circle" ></i></span>
            </div>
        @else
            <div class="header-icons-item wrapper-link-hover">
                <a href="{{route('auth.login')}}" class="link-hover">Đăng nhập</a>
            </div>
            <div class="header-icons-item header-icons-item-hide wrapper-link-hover">
                <a href="{{route('auth.register')}}" class="link-hover">Đăng ký</a>
            </div>
        @endif
    </div>
</div>

<script src="{{asset('assets/front/js/header.js')}}"></script>
