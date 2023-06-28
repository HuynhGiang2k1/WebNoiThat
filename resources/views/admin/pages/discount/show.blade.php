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
        <div class="container-fluid">
            <div class="row">
                <div class="white-box">
                    <div class="table-responsive">
                        <table class="table no-wrap">
                            <tr>
                                <th>#</th>
                                <td>{{$discount->id}}</td>
                            </tr>
                            <tr>
                                <th>Tiêu đề</th>
                                <td>{{$discount->title}}</td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td>{{$discount->description}}</td>
                            </tr>
                            <tr>
                                <th>Loại</th>
                                <td>
                                    @if($discount->is_percent)
                                        <span class="text-success">Phần trăm</span>
                                    @else
                                        <span class="text-success">Giá tiền</span>
                                    @endif</td>
                            </tr>
                            <tr>
                                <th>Giá trị</th>
                                <td>{{$discount->val}}</td>
                            </tr>
                            <tr>
                                <th>Này bắt đầu</th>
                                <td>{{date('d/m/Y', $discount->term_start)}}</td>
                            </tr>
                            <tr>
                                <th>Ngày kết thúc</th>
                                <td>{{date('d/m/Y', $discount->term_end)}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="white-box">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Danh sách sản phẩm dự dịnh</h4>
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
@endsection
