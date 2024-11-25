@extends('admin.layouts.master')

@section('title')
Hoàn hàng
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong>Hoàn hàng</strong>
        </div>
        <div class="card-body card-block">
            <form action="{{ route('refund.store') }}" method="post" enctype="multipart/form-data"
                class="form-horizontal">
                @csrf

                <!-- Mã đơn hàng -->
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <label for="order_code" class="form-control-label">Mã đơn hàng</label>
                        <input type="text" id="order_code" name="order_code" placeholder="Nhập mã đơn hàng"
                            class="form-control" value="{{ old('order_code') }}">
                        @error('order_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Lý do hoàn hàng -->
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <label for="reason" class="form-control-label">Lý do hoàn hàng</label>
                        <select name="reason" id="reason" class="form-control">
                            <option value="">Vui lòng chọn lý do</option>
                            <option value="NOT_RECEIVED" {{ old('reason') == 'NOT_RECEIVED' ? 'selected' : '' }}>Chưa nhận
                                được hàng</option>
                            <option value="MISSING_ITEMS" {{ old('reason') == 'MISSING_ITEMS' ? 'selected' : '' }}>Thiếu
                                sản phẩm</option>
                            <option value="DAMAGED_ITEMS" {{ old('reason') == 'DAMAGED_ITEMS' ? 'selected' : '' }}>Sản
                                phẩm bị hư hỏng</option>
                            <option value="INCORRECT_ITEMS" {{ old('reason') == 'INCORRECT_ITEMS' ? 'selected' : '' }}>Sản
                                phẩm không đúng</option>
                            <option value="FAULTY_ITEMS" {{ old('reason') == 'FAULTY_ITEMS' ? 'selected' : '' }}>Sản phẩm
                                bị lỗi</option>
                            <option value="DIFFERENT_FRON_THE_DESCRIPTION" {{ old('reason') == 'DIFFERENT_FRON_THE_DESCRIPTION' ? 'selected' : '' }}>Sản phẩm khác mô tả
                            </option>
                            <option value="USED_ITEMS" {{ old('reason') == 'USED_ITEMS' ? 'selected' : '' }}>Sản phẩm đã
                                qua sử dụng</option>
                        </select>
                        @error('reason')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Mô tả chi tiết -->
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <label for="description" class="form-control-label">Mô tả chi tiết</label>
                        <textarea name="description" id="description" placeholder="Mô tả chi tiết lý do hoàn hàng"
                            class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Upload ảnh (nếu có) -->
                <div class="row form-group">
                    <div class="col-12 col-md-12">
                        <label for="image" class="form-control-label">Ảnh minh họa</label>
                        <input type="file" id="image" name="image" class="form-control">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Nút Submit -->
                <div class="form-actions form-group">
                    <a href="{{ route('refund.index') }}" class="btn btn-primary btn-sm">Quay lại</a>
                    <button type="submit" class="btn btn-success btn-sm">Hoàn tất</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
