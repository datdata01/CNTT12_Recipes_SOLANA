@extends('admin.layouts.master')
@section('title')
    Phiếu giảm Giá
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Cập Nhật Phiếu Giảm Giá</strong>
        </div>
        <div class="card-body card-block">
            <form action="{{ route('voucher.update', $voucher->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="" class="form-control-label">Loại voucher</label>
                            <select name="type" class="form-control">
                                <option value="OTHER" {{ $voucher->type == 'OTHER' ? 'selected' : '' }}>
                                    Khác
                                </option>
                                <option value="REGISTER" {{ $voucher->type == 'REGISTER' ? 'selected' : '' }}>
                                    Áp dụng cho khách hàng mới</option>
                                <option value="SUCCESS" {{ $voucher->type == 'FIXED' ? 'selected' : '' }}>
                                    Áp dụng khi mua hàng thành công
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name" class="form-control-label">Tên loại voucher</label>
                            <input type="text" name="name" value="{{ $voucher->name }}"
                                placeholder="Tên loại voucher.." class="form-control">
                            @if ($errors->has('name'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="code" class="form-control-label">Mã voucher</label>
                            <input type="text" name="code" value="{{ $voucher->code }}" placeholder="Mã voucher.."
                                class="form-control">
                            @if ($errors->has('code'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('code') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="start_date" class="form-control-label">Ngày bắt đầu</label>
                            <input type="datetime-local" name="start_date" value="{{ $voucher->start_date }}"
                                class="form-control">
                            @if ($errors->has('start_date'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('start_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="end_date" class="form-control-label">Ngày kết thúc</label>
                            <input type="datetime-local" name="end_date" value="{{ $voucher->end_date }}"
                                class="form-control">
                            @if ($errors->has('end_date'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('end_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="limit" class="form-control-label">Số lượng voucher</label>
                            <input type="number" name="limit" value="{{ $voucher->limit }}"
                                placeholder="Số lượng voucher.." class="form-control">
                            @if ($errors->has('limit'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('limit') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Gới hạn sử dụng cho 1 tài khoản</label>
                            <input type="number" name="limited_uses" placeholder="Nhập giới hạn." class="form-control"
                                value="{{ $voucher->limited_uses }}">
                            @if ($errors->has('limited_uses'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('limited_uses') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="discount_type" class="form-control-label">Kiểu giảm giá</label>
                            <select name="discount_type" class="form-control">
                                <option value="PERCENTAGE" {{ $voucher->discount_type == 'PERCENTAGE' ? 'selected' : '' }}>
                                    Giảm theo giá trị phần trăm
                                </option>
                                <option value="FIXED" {{ $voucher->discount_type == 'FIXED' ? 'selected' : '' }}>
                                    Giảm theo giá cố định
                                </option>
                            </select>
                            @if ($errors->has('discount_type'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('discount_type') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="discount_value" class="form-control-label">Giá trị giảm</label>
                            <input type="number" name="discount_value" value="{{ $voucher->discount_value }}"
                                placeholder="Giá trị giảm.." class="form-control">
                            @if ($errors->has('discount_value'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('discount_value') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="min_order_value" class="form-control-label">Giá trị đơn hàng tối thiểu</label>
                            <input type="number" name="min_order_value" value="{{ $voucher->min_order_value }}"
                                placeholder="Giá trị đơn hàng tối thiểu.." class="form-control">
                            @if ($errors->has('min_order_value'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('min_order_value') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="max_order_value" class="form-control-label">Giá trị đơn hàng tối đa</label>
                            <input type="number" name="max_order_value" value="{{ $voucher->max_order_value }}"
                                placeholder="Giá trị đơn hàng tối đa.." class="form-control">
                            @if ($errors->has('max_order_value'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('max_order_value') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="status" class="form-control-label">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="ACTIVE" {{ $voucher->status == 'ACTIVE' ? 'selected' : '' }}>Hoạt động
                                </option>
                                <option value="IN_ACTIVE" {{ $voucher->status == 'IN_ACTIVE' ? 'selected' : '' }}>Không
                                    hoạt
                                    động</option>
                            </select>
                            @if ($errors->has('status'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Mô tả thêm về voucher</label>
                            <input type="text" name="description" value="{{ $voucher->description }}"
                                placeholder="Mô tả về voucher.." class="form-control">
                            @if ($errors->has('description'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('voucher.index') }}">Quay lại</a>
                    <button type="submit" class="btn btn-success px-5">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection
