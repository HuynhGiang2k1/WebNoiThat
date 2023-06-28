@extends('admin.base')

@section('page-content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">ÁP DỤNG KHUYẾN MÃI</h4>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <div class="form-group d-md-flex mb-3">
                            <form action="" method="get" class="form-search-product">
                                <table border="1">
                                    <tr>
                                        <th class="form-search-product-text">ID</th>
                                        <td><input type="text" name="id" class="form-search-product-input-text"></td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td class="form-search-product-text-error">
                                            @error('id')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="form-search-product-text">Tên</th>
                                        <td><input type="text" name="name" class="form-search-product-input-text"></td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <td class="form-search-product-text-error">
                                            @error('name')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </td>
                                    </tr>
                                    <tr>
                                    <th class="form-search-product-text">Danh mục</th>
                                    <td class="form-search-product-categories">
                                        <div class="form-search-product-categories-content">
                                            @foreach($categories as $category)
                                                <div class="form-search-product-categories-item">
                                                    @if(count($category->subcategories)==0)
                                                        <div class="form-search-product-categories-item-item">
                                                            <input type="checkbox" value="{{$category->id}}" name="categories[]" id="cate{{$category->id}}">
                                                            <label for="cate{{$category->id}}">{{$category->name}}</label>
                                                        </div>
                                                    @else
                                                        @foreach($category->subcategories as $sub)
                                                            <div class="form-search-product-categories-item-item">
                                                                <input type="checkbox" value="{{$sub->id}}" name="subcategories[]" id="subcate{{$sub->id}}">
                                                                <label for="subcate{{$sub->id}}">{{$sub->name}}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                </table>
                                <div class="form-search-product-item">
                                <button class="btn-search">Tìm kiếm</button>
                            </div>
                            </form>
                        </div>
                        <div class="form-group">
                            <form action="{{route('admin.discount.apply', [$id])}}" method="post">
                                @csrf
                                @method('post')
                                <input type="hidden" name="productIds" value="{{json_encode($products ? $products->modelKeys() : [])}}">
                                <div>
                                    <button type="submit" class="btn btn-success mt-4" style="padding: 5px 30px;">
                                        Áp dụng
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table no-wrap">
                                <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Tên sản phẩm</th>
                                    <th class="border-top-0">Hình ảnh</th>
                                    <th class="border-top-0">Size</th>
                                    <th class="border-top-0">Giá</th>
                                    <th class="border-top-0">Danh mục</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{$product->id}}</td>
                                        <td class="txt-oflo">{{$product->name}}</td>
                                        <td>
                                            <img style="width: 100px;" src="{{asset('products/'.$product->cover)}}" alt="">
                                        </td>
                                        <td class="txt-oflo" style="max-width: 100px; text-overflow: ellipsis; overflow: hidden;">{{$product->size}}</td>
                                        <td class="txt-oflo">
                                            <x-money :amount="$product->price" />
                                        </td>
                                        <td class="txt-oflo">
                                            @php
                                                foreach ($product->categories as $cate) {
                                                    echo $cate->name.", ";
                                                }
                                                foreach ($product->subcategories as $sub) {
                                                    echo $sub->name.", ";
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <style>

    html ::-webkit-scrollbar {
        border-radius: 0;
        height: 9px;
        width: 9px;
    }

    html ::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,.15);
        border-radius: 4px;
    }

    .form-search-product{
        position: relative;
        width: 100%;
        font-family: "EB Garamond",serif;
        font-size: 18px;
        font-weight: 400;
    }

    .form-search-product::after{
        position: absolute;
        content: '';
        width:100%;
        height:1px;
        background-color: #ccc;
        bottom: -10px;
        left: 0;
    }

    .form-search-product table{
        width: 100%;
        border: none;
    }

    .form-search-product table th{
        width: 100px;
    }

    .form-search-product .form-search-product-text{
        display: block;
        margin-right: 20px;
        font-family: "Open Sans",sans-serif;
        font-size: 15px;
        line-height: 1.8em;
        font-weight: 400;
        color: #8b8b8b;
    }

    .form-search-product .form-search-product-text-error{
        display: block;
        margin: 4px 0 4px 10px;
        font-family: "Open Sans",sans-serif;
        font-size: 12px;
        line-height: 1.8em;
        font-weight: 400;
        color: red;
    }

    .form-search-product .form-search-product-input-text{
        margin-bottom: 10px;
        display: block;
        width: 300px;
        padding: 6px 20px;
        font-family: "EB Garamond",serif;
        font-size: 16px;
        font-style: italic;
        line-height: 12px;
        font-weight: inherit;
        color: #8b8b8b;
        border: 1px solid #ddd;
        outline: 0;
        cursor: pointer;
    }

    .form-search-product .form-search-product-categories{
        width: 100%;
    }

    .form-search-product .form-search-product-categories-content{
        display: block;
        max-width: 35%;
        height: 120px;
        overflow: hidden;
        overflow-y: scroll;
    }


    .form-search-product .form-search-product-categories-item-item{
        padding: 10px 5px;
        display:flex;
        align-items: center;
        text-align: center;
        flex-direction: row;
        width: 200px;
    }


    .form-search-product .form-search-product-categories-item input{
        margin-left: 10px;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .form-search-product .form-search-product-categories-item label{
        margin: 0;
        display: block;
        padding-left: 10px;
        margin-left: 2px;
        font-family: "EB Garamond",serif;
        font-size: 16px;
        font-style: italic;
        line-height: 12px;
        font-weight: inherit;
        color: #8b8b8b;
        background-color: transparent;
        outline: 0;
        cursor: pointer;
    }

    .form-search-product .form-search-product-item{
        width: 100%;
        text-align: right;
    }

    .form-search-product .btn-search{
        padding: 3px 10px;
        background-color: transparent;
        border: 1px solid #8b8b8b;
        border-radius: 5px;
        font-style: italic;
        color: #1d1d1d;
        text-transform: capitalize;
    }

    .form-search-product .btn-search:hover{
        border: 1px solid #1d1d1d;
        color: #8b8b8b;
        transition: all 0.5s ease-in-out;
    }
    </style>
@endsection
