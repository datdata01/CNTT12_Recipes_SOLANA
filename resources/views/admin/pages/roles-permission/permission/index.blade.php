@extends('admin.layouts.master')

@section('title')
    Vai trò
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Thêm mới</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('permission.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Cấp quyền</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Nhập quyền" value="{{ old('name') }}">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn btn-success btn-sm">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Danh sách các quyền</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">Tên quyền</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $index => $list)
                            <tr>
                            <th scope="row" class="text-center">{{ $index + 1 }}</th>
                            <td class="text-center">{{ $list->name }}</td>
                            <td class="text-center">
                                        <a href="{{ route('permission.edit', $list->id) }}" class="btn btn-warning">Sửa</a>
                                        <form action="{{ route('permission.destroy', $list->id) }}" method="POST"
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

                </div>
            </div>
        </div>
    </div>
@endsection
