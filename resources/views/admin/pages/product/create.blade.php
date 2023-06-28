@extends('admin.base')

@section('page-content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">THÊM MỚI SẢN PHẨM</h4>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="white-box col-md-12 col-lg-6 col-sm-12 m-auto">
                    <div class="form-group">
                        <form action="{{route('admin.product.store')}}" method="post"
                              method="post" enctype="multipart/form-data">
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Tên sản phẩm:</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Giá:</label>
                                <input type="text" class="form-control" name="price" value="{{old('price')}}">
                                @error('price')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Số lượng:</label>
                                <input type="text" class="form-control" name="quantity" value="{{old('quantity')}}">
                                @error('quantity')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Kích cỡ:</label>
                                <input type="text" class="form-control" name="size" value="{{old('size')}}">
                                @error('size')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Mô tả:</label>
                                <textarea class="form-control" id="floatingTextarea2" style="height: 120px"
                                          name="description"
                                >{{old('description')}}</textarea>
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Ảnh chính:</label>
                                <input type="file" class="form-control" name="cover" >
                                @error('cover')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Ảnh phụ:</label>
                                <input type="file" class="form-control" name="images[]"
                                       multiple>
                            </div>
                            <div class="mt-2" style="margin-bottom:20px; height: 150px;overflow: hidden; overflow-y: scroll;">
                                <label style="display: inline-block; margin-bottom: 10px;">Danh mục:</label><br>
                                @foreach($categories as $category)
                                    @if(count($category->subcategories)==0)
                                        <div>
                                            <input type="checkbox" value="{{$category->id}}" name="categories[]" id="cate{{$category->id}}">
                                            <label for="cate{{$category->id}}">{{$category->name}}</label>
                                        </div>
                                    @else
                                        @foreach($category->subcategories as $sub)
                                            <div>
                                                <input type="checkbox" value="{{$sub->id}}" name="subcategories[]" id="subcate{{$sub->id}}">
                                                <label for="subcate{{$sub->id}}">{{$sub->name}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                                @error('subcategories')
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

    html ::-webkit-scrollbar {
        border-radius: 0;
        height: 9px;
        width: 9px;
    }

    html ::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,.15);
        border-radius: 4px;
    }
    </style>
@endsection
