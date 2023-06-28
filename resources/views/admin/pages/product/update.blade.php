@extends('admin.base')

@section('page-content')
    <div class="page-wrapper">
        <div class="page-breadcrumb bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">THÔNG TIN SẢN PHẨM</h4>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <p>Ảnh chính:</p>
                    <img src="{{asset('products/'.$product->cover)}}"
                         alt="{{$product->cover}}" style="max-width: 100px;
                                     max-height: 100px">
                    <br>
                    <p>Ảnh phụ:</p>
                    @foreach($images as $image)
                        <form action="{{route('admin.product.deleteimg', [$image->id])}}" method="post">
                            <button type="submit" class="btn text-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            @csrf
                            @method('delete')
                        </form>
                        <img src="{{asset('products/'.$image->name)}}"
                             alt="{{$image->name}}" style="max-width: 100px;
                                     max-height: 100px">
                        <br>
                    @endforeach
                </div>

                <div class="white-box col-md-12 col-lg-6 col-sm-12">
                    <div class="form-group">
                        <form action="{{route('admin.product.update', [$product->id])}}" method="post"
                              method="post" enctype="multipart/form-data">
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Tên sản phẩm:</label>
                                <input type="text" class="form-control" name="name" value="{{$product->name}}">
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Giá:</label>
                                <input type="text" class="form-control" name="price" value="{{$product->price}}">
                                @error('price')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Số lượng:</label>
                                <input type="text" class="form-control" name="quantity" value="{{$product->quantity}}">
                                @error('quantity')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Kích cỡ:</label>
                                <input type="text" class="form-control" name="size" value="{{$product->size}}">
                                @error('size')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Mô tả:</label>
                                <textarea class="form-control" id="floatingTextarea2" style="height: 120px"
                                          name="description"
                                >{{$product->description}}</textarea>
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
                            <div class="mt-2" style="margin-bottom:20px">
                                <label style="display: inline-block; margin-bottom: 5px;">Danh mục:</label><br>
                                @foreach($categories as $category)
                                    @if(count($category->subcategories)==0)
                                        <div>
                                            <input type="checkbox" value="{{$category->id}}"
                                                   @php echo in_array($category->id, $product->categories->pluck('id')->toArray()) ?
                                                   "checked": ""
                                                   @endphp
                                                   name="categories[]" id="cate{{$category->id}}">
                                            <label for="cate{{$category->id}}">{{$category->name}}</label>
                                        </div>
                                    @else
                                        @foreach($category->subcategories as $sub)
                                            <div>
                                                <input type="checkbox" value="{{$sub->id}}"
                                                       @php echo in_array($sub->id, $product->subcategories->pluck('id')->toArray()) ?
                                                        "checked": ""
                                                       @endphp
                                                       name="subcategories[]" id="subcate{{$sub->id}}">
                                                <label for="subcate{{$sub->id}}">{{$sub->name}}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                                @error('subcategories')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div style="width: 100%; text-align: center;"><button type="submit" class="btn btn-success mt-4" style="padding: 5px
                            30px;">Sửa</button></div>
                            @csrf
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
