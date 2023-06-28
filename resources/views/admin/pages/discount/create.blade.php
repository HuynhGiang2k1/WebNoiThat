@extends('admin.base')

@section('page-content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">THÊM MỚI KHUYẾN MÃI</h4>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="white-box col-md-12 col-lg-6 col-sm-12 m-auto">
                    <div class="form-group">
                        <form action="{{route('admin.discount.store')}}" method="post"
                              method="post" enctype="multipart/form-data">
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Tiêu đề:</label>
                                <input type="text" class="form-control" name="title" value="{{old('title')}}">
                                @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Mô tả:</label>
                                <textarea class="form-control" id="floatingTextarea2" style="height: 120px"
                                          name="description"
                                >{{old('description')}}</textarea>
                                @error('description')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px; display: flex; align-items:center;">
                                <label style="margin-bottom: 0;">Giảm giá theo phần trăm:</label>
                                <input style="margin-left: 10px;" type="checkbox" name="is_percent">
                                @error('percent')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Giá trị:</label>
                                <input type="text" class="form-control" name="val" value="{{old('val')}}">
                                @error('val')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Ngày bắt đầu</label>
                                <input type="text" class="form-control datetimepicker" name="term_start">
                                @error('term_start')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Ngày kết thúc</label>
                                <input type="text" class="form-control datetimepicker" name="term_end">
                                @error('term_end')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div style="width: 100%; text-align: center;"><button type="submit" class="btn btn-success mt-4" style="padding: 5px 30px;">Thêm mới</button></div>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .datetimepicker{
            background: transparent !important;
        }
    </style>
    <script>
        const datetimepicker = document.getElementsByClassName('datetimepicker');
        for(i = 0; i < datetimepicker.length; i++){
            flatpickr(datetimepicker[i], {
            enableTime: true,
            dateFormat: "Y-m-d",
            });
        }
    </script>
@endsection

