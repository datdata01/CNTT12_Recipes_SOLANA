@extends('admin.layouts.master')
@section('title')
    Phiếu Giảm Giá
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Thêm Mới Voucher</strong>
        </div>
        <div class="card-body card-block">
            <form action="{{ route('voucher.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="" class="form-control-label">Tên loại voucher</label>
                            <input type="text" name="name" placeholder="Tên loại voucher.." class="form-control"
                                value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Mô tả về voucher</label>
                            <input type="text" name="description" placeholder="Mô tả về voucher.." class="form-control"
                                value="{{ old('description') }}">
                            @if ($errors->has('description'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Ngày bắt đầu</label>
                            <input type="datetime-local" name="start_date" class="form-control"
                                value="{{ old('start_date') }}">
                            @if ($errors->has('start_date'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('start_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Ngày kết thúc</label>
                            <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}">
                            @if ($errors->has('end_date'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('end_date') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Số lượng voucher</label>
                            <input type="number" name="limit" placeholder="Số lượng voucher.." class="form-control"
                                value="{{ old('limit') }}">
                            @if ($errors->has('limit'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('limit') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="" class="form-control-label">Kiểu giảm giá</label>
                            <select name="discount_type" class="form-control">
                                <option value="PERCENTAGE">Giảm theo giá trị phần trăm</option>
                                <option value="FIXED">Giảm theo giá cố định</option>
                            </select>
                            @if ($errors->has('discount_type'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('discount_type') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Giá trị giảm</label>
                            <input type="number" name="discount_value" placeholder="Giá trị giảm.." class="form-control"
                                value="{{ old('discount_value') }}">
                            @if ($errors->has('discount_value'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('discount_value') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Giá trị đơn hàng tối thiểu</label>
                            <input type="number" name="min_order_value" placeholder="Giá trị đơn hàng tối thiểu.."
                                class="form-control" value="{{ old('min_order_value') }}">
                            @if ($errors->has('min_order_value'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('min_order_value') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Giá trị đơn hàng tối đa</label>
                            <input type="number" name="max_order_value" placeholder="Giá trị đơn hàng tối đa.."
                                class="form-control" value="{{ old('max_order_value') }}">
                            @if ($errors->has('max_order_value'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('max_order_value') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="ACTIVE">Hoạt động</option>
                                <option value="IN_ACTIVE">Không hoạt động</option>
                            </select>
                            @if ($errors->has('status'))
                                <div class="form-text badge text-danger">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <a class="btn btn-warning" href="{{ route('voucher.index') }}">Quay lại</a>
                    <button type="submit" class="btn btn-success px-5">Thêm</button>
                </div>
            </form>
        </div>
    </div>
@endsection
