@extends('admin.layouts.master')

@section('title', 'Gán quyền cho vai trò')

@section('content')
<style>
    /* Container chứa checkbox */
.form-check {
    display: inline-flex;
    align-items: center;
    margin-right: 20px; /* Khoảng cách giữa các checkbox */
}

/* Ẩn checkbox mặc định */
.form-check-input {
    display: none;
}

/* Tùy chỉnh giao diện checkbox */
.form-check-input + .form-check-label {
    display: inline-flex;
    align-items: center;
    cursor: pointer;
    padding-left: 30px;
    position: relative;
}

/* Thêm một khung giả để thay thế checkbox */
.form-check-input + .form-check-label::before {
    content: '';
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid #007bff;
    border-radius: 4px;
    background-color: #fff;
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    transition: all 0.3s;
}

/* Thay đổi trạng thái khi checkbox được chọn */
.form-check-input:checked + .form-check-label::before {
    background-color: #007bff;
    border-color: #007bff;
    content: '✔';
    color: white;
    text-align: center;
    font-size: 14px;
    line-height: 18px;
}

/* Thay đổi khi hover */
.form-check-input + .form-check-label:hover::before {
    border-color: #0056b3;
}
</style>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <strong>Gán quyền cho vai trò: {{ $role->name }}</strong>
                </div>
                <div class="card-body">
                    <p class="text-muted">Chọn các quyền để gán cho vai trò <strong>{{ $role->name }}</strong>.</p>
                    <form action="{{ route('role.assign-permissions', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="permissions" class="form-label">Danh sách quyền</label>
                            <div class="form-check-container">
                                @foreach ($permissions as $permission)
                                <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="permission-{{ $permission->id }}" value="{{ $permission->name }}"
                                    {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                {{ $permission->name }}
                                </label>
                            </div>
                                @endforeach
                        </div>
                            @error('permissions')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('new-role.index') }}" class="btn btn-secondary">
                                Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
