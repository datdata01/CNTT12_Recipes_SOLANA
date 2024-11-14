@extends('admin.layouts.master')

@section('title')
    Danh sách người dùng
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title"> Danh sách người dùng</strong>
        </div>

        <div class="card-body">
            <div class="text-end mb-3">
                <a class="btn btn-success" href="{{ route('users.create') }}">Thêm mới</a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">ảnh đại diện</th>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Vai trò</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>
                                <img src="{{ '/Storage/' . $user->image }}" alt="" width="70px">
                            </td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->status == 'ACTIVE')
                                    <span class="badge bg-primary">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Ngưng hoạt động!</span>
                                @endif
                            </td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge bg-info">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <div>
                                    <div class="d-flex justify-content-center">
                                        <div class="mr-1">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#userDetailModal-{{ $user->id }}">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                        </div>
                                        <div class="mr-1">
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        </div>
                                        <div>
                                            <form action="{{ route('users.destroy', $user) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Có chắc chắn muốn xóa không?')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                            </td>
                        </tr>

                        @include('admin.pages.user.show')
                    @endforeach

                </tbody>
            </table>

            {{ $data->links() }}
        </div>
    </div>
@endsection
