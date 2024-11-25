@extends('admin.layouts.master')

@section('title')
    Thêm mới người dùng 2.0
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><strong>Thêm mới người dùng 2.0</strong></div>
        <div class="card-body card-block">
            <form action="{{ route('new-user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-8">
                        <!-- Họ và tên -->
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                placeholder="Nhập họ và tên" value="{{ old('full_name') }}" >
                            @error('full_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Số điện thoại -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
                            @error('phone')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Nhập email" value="{{ old('email') }}" >
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mật khẩu -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Nhập mật khẩu" >
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <!-- Trạng thái -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="ACTIVE" {{ old('status') == 'ACTIVE' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="IN_ACTIVE" {{ old('status') == 'IN_ACTIVE' ? 'selected' : '' }}>Ngưng hoạt động</option>
                            </select>
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vai trò (Checkbox) -->
                        <div class="mb-3">
                            <label class="form-label">Vai trò</label><br>
                            @foreach ($roles as $id => $name)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="role_{{ $id }}"
                                        name="roles[]" value="{{ $id }}"
                                        {{ in_array($id, old('roles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $id }}">
                                        {{ $name }}
                                    </label>
                                </div>
                            @endforeach
                            @error('roles')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ảnh đại diện -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh đại diện</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <a class="btn btn-primary btn-sm" href="{{ route('new-user.index') }}">Quay lại</a>
                    <button type="submit" class="btn btn-success btn-sm">Thêm mới</button>
                </div>
            </form>
        </div>
    </div>
@endsection
