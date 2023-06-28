@extends('admin.base')

@section('page-content')
    <div class="page-wrapper min-vh-100">
        <div class="page-breadcrumb bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">THÊM MỚI DANH MỤC</h4>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="d-flex justify-content-between gap-5" style="width: max-content; min-width: 1200px; padding-top:20px;">
            <div class="card" style="width: 500px; height: max-content; margin-left: 20px;">
                <div class="card-header bg-secondary">
                    <h3>Thêm mới</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.categories.store')}}" method="post" enctype="multipart/form-data">
                        <div class="mt-2">
                            <lable style="margin-bottom: 8px; display: inline-block;">Tên danh mục:</lable>
                            <input type="text" class="form-control" name="name">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <lable style="margin-bottom: 8px; display: inline-block;">Tên không dấu:</lable>
                            <input type="text" class="form-control" name="name_en">
                            @error('name_en')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div style="width:100%; text-align: right;"><button type="submit" class="btn btn-success mt-4">Thêm mới</button></div>
                        @csrf
                    </form>
                </div>
            </div>

            <div class="card" style="height: max-content; flex-grow: 1;">
                <div class="card-header bg-secondary">
                    <h3>Danh mục</h3>
                </div>
                <div class="card-body">
                    <table class="table " >
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Tên không dấu</th>
                            <th scope="col" colspan="2">Tác vụ</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <th scope="row">{{$category->id}}</th>
                                <td>{{$category->name}}</td>
                                <td>{{$category->name_en}}</td>
                                <td>
                                    <span data-bs-toggle="modal"
                                       data-bs-target="#updateModal"
                                       data-category-name="{{$category->name}}"
                                       data-category-name-en="{{$category->name_en}}"
                                       data-category-id="{{$category->id}}"
                                    >
                                        <i class="far fa-edit"></i>
                                    </span>
                                </td>
                                <td>
                                    <span data-bs-toggle="modal"
                                       data-bs-target="#modal{{$category->id}}">
                                        <i class="fas fa-trash-alt"></i>
                                    </span>
                                </td>
                            </tr>
                            <div class="modal fade" id="modal{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5"
                                                id="exampleModalLabel">Xóa</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có muốn xóa danh mục "{{$category->name}}" hay không ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Trở lại
                                            </button>
                                            <form action="{{route('admin.categories.delete', $category->id)}}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger" type="submit">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{--            UpdateModal--}}
                <div class="modal fade" id="updateModal" tabindex="-1"
                     aria-labelledby="updateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="updateModalLabel">New
                                    message</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('admin.categories.update')}}" method="post">
                                    <input type="hidden" name="id" id="category-id">
                                    <div class="mb-3">
                                        <label for="category-name" class="col-form-label">Tên danh mục:</label>
                                        <input type="text" class="form-control" id="category-name" name="name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="category-name"
                                               class="col-form-label">Tên không dấu:</label>
                                        <input type="text" class="form-control" id="category-name-en" name="name_en">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Sửa</button>
                                    @csrf
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Trở lại</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const updateModal = document.getElementById('updateModal')
        updateModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const categoryName = button.getAttribute('data-category-name')
            const categoryNameEn = button.getAttribute('data-category-name-en')

            const categoryId = button.getAttribute('data-category-id')

            const modalTitle = updateModal.querySelector('.modal-title')
            const categoryInput = updateModal.querySelector('#category-name')
            const categoryEnInput = updateModal.querySelector('#category-name-en')
            const categoryIdInput = updateModal.querySelector('#category-id')


            modalTitle.textContent = `Sửa danh mục ${categoryName}`
            categoryInput.value = categoryName
            categoryIdInput.value = categoryId
            categoryEnInput.value = categoryNameEn
        })
    </script>
@endsection
