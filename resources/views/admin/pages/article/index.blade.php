@extends('admin.layouts.master')
@section('title')
    Danh sách bài viết
@endsection
@section('content')
    <div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Danh sách bài viết</strong>
                </div>
                <div class="card-body">
                    <table style="table-layout: fixed; width: 100%;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="15px">STT</th>
                                <th scope="col" width="50px">Danh mục</th>
                                <th scope="col" width="200px">Tiêu đề</th>
                                <th scope="col" width="80px">Hình ảnh đại diện</th>
                                <th scope="col" width="40px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div style="text-align: right;">
                                <a href="{{ route('article.create') }}" class="btn btn-success">Thêm mới</a>
                            </div>
                            <br>
                            @foreach ($listArticle as $index => $list)
                                <tr>
                                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                    <td class="text-center">{{ $list->categoryArticle->name ?? 'Không có danh mục' }}</td>
                                    <td class="text-center">{{ $list->title }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $list->image) }}" alt="" width="100px"
                                            height="100px">
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('article.edit', $list->id) }}" class="btn btn-warning">
                                            <i class="fa fa-pencil"></i></a>
                                        <form action="{{ route('article.destroy', $list->id) }}" method="POST"
                                            style="display:inline;" id="delete-form-{{ $list->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?') ? document.getElementById('delete-form-{{ $list->id }}').submit() : false;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $listArticle->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
