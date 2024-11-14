@extends('admin.layouts.master')

@section('title')
    Cập nhật vai trò: {{ $role->name }}
@endsection

@section('content')
<div class="row d-flex justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><strong>Cập nhật vai trò: {{ $role->name }}</strong></div>
            <div class="card-body card-block">
                <form action="{{ route('roles.update', $role) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên vai trò</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Nhập tên vai trò" value="{{ $role->name }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="3">{{ $role->description }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}" >Quay lại</a>
                        <button type="submit" class="btn btn-success btn-sm">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
   
@endsection
