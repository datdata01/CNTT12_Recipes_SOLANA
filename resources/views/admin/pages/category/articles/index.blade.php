@extends('admin.layouts.master')
@section('title')
    Danh mục bài viết
@endsection
@section('content')
    <div class="row">
        <!-- Cột 1 -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header fw-bold">Thêm danh mục bài viết</div>
                <div class="card-body card-block">
                    <form action="{{ route('category-article.store') }}" method="post" enctype="multipart/form-data"
                        class="">
                        @csrf
                        <div class="form-group">
                        <label for="full_name" class="form-label">Tên danh mục</label>
                            <div class="input-group">
                                <input type="text" id="name" name="name" placeholder="Tên danh mục"
                                    class="form-control" value="{{ old('name') }}">
                            </div>
                            <!-- Hiển thị lỗi dưới input -->
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-actions form-group">
                            <button type="submit" class="btn btn-success btn-sm">Thêm mới</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Danh mục bài viết</strong>
                </div>
                <div class="card-body">
                    <table class="table-bordered table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Tên</th>
                                <th scope="col" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listCategoryArticle as $index => $list)
                                <tr>
                                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                    <td class="text-center">{{ $list->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('category-article.edit', $list->id) }}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('category-article.destroy', $list->id) }}" method="POST"
                                            style="display:inline;" id="delete-form-{{ $list->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?') ? document.getElementById('delete-form-{{ $list->id }}').submit() : false;">
                                               Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $listCategoryArticle->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
