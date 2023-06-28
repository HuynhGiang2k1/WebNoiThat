@extends('admin.base')

@section('page-content')
    <div class="page-wrapper min-vh-100">
        <div class="page-breadcrumb bg-white">
            <div class="row align-items-center ">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Thông tin tài khoản</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <div class="d-md-flex">
                        <ol class="breadcrumb ms-auto">
                            <li><a href="{{route('admin')}}" class="fw-normal">Dashboard</a></li>
                        </ol>
                        <a href="{{route('admin.users')}}"
                           class="btn btn-primary  d-none d-md-block pull-right ms-3 hidden-xs hidden-sm waves-effect waves-light text-white">
                            Danh sách tài khoản
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-12">
                    <div class="white-box">
                        <div class="user-bg"> <img width="100%" alt="user" src="plugins/images/large/img1.jpg">
                            <div class="overlay-box">
                                <div class="user-content">
                                    <a href="javascript:void(0)"><img src="plugins/images/users/genu.jpg"
                                                                      class="thumb-lg img-circle" alt="img"></a>
                                    <h4 class="text-white mt-2">{{$user->name}}</h4>
                                    <h5 class="text-white mt-2">{{$user->email}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="user-btm-box mt-5 d-md-flex">
                            <div class="col-md-4 col-sm-4 text-center">
                                <h1>258</h1>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                                <h1>125</h1>
                            </div>
                            <div class="col-md-4 col-sm-4 text-center">
                                <h1>556</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xlg-9 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal form-material" action="{{route('admin.user.update', [$user])}}" method="post">
                                @csrf
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0" >Họ và tên</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" value="{{$user->name}}"
                                               class="form-control p-0 border-0" name="name">
                                        @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Email</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="email" value="{{$user->email}}"
                                               class="form-control p-0 border-0" name="email">
                                        @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Mật khẩu</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="password"
                                               class="form-control p-0 border-0" name="password">
                                        @error('password')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Số điện thoại</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" value="{{$user->tel}}"
                                               class="form-control p-0 border-0" name="tel" >
                                        @error('tel')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label class="col-md-12 p-0">Địa chỉ</label>
                                    <div class="col-md-12 border-bottom p-0">
                                        <input type="text" value="{{$user->address}}"
                                               class="form-control p-0 border-0" disabled>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" type="submit">Cập nhật</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
