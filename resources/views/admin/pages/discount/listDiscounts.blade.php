@extends('admin.base')

@section('page-content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Khuyến mãi</h4>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <div class="d-md-flex mb-3">
                            <a href="{{route('admin.discount.create')}}" class="btn btn-primary">Thêm mới</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table no-wrap">
                                <thead>
                                <tr>
                                    <th class="border-top-0">#</th>
                                    <th class="border-top-0">Title</th>
                                    <th class="border-top-0">Mô tả</th>
                                    <th class="border-top-0">Loại</th>
                                    <th class="border-top-0">Giá trị</th>
                                    <th class="border-top-0">Tác vụ</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($discounts as $discount)
                                    <tr>
                                        <td>{{$discount->id}}</td>
                                        <td>{{$discount->title}}</td>
                                        <td class="txt-oflo">{{$discount->description}}</td>
                                        <td>
                                            @if($discount->is_percent)
                                                <span class="text-success">Phần trăm</span>
                                            @else
                                                <span class="text-success">Giá tiền</span>
                                            @endif
                                        </td>
                                        <td><span>{{$discount->val}}</span></td>
                                        <td>
                                            <a href="{{route('admin.discount.detail', [$discount->id])}}" class="btn btn-secondary btn-sm">Xem</a>
                                            <a href="{{route('admin.discount.formApply', [$discount->id])}}"
                                               class="btn btn-primary btn-sm">Áp dụng</a>
                                            <a href="{{route('admin.discount.edit', [$discount->id])}}"
                                               class="btn btn-warning btn-sm">Sửa</a>
                                            <form action="{{route('admin.discount.delete', [$discount->id])}}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" type="submit"
                                                        onclick="return confirm('Bạn có thực sự muốn xóa?');">
                                                    Xóa
                                                </button>
                                            </form>
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
@endsection
