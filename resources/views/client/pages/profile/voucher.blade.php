@extends('client.pages.profile.layouts.master')

@section('title')
    Ưu đãi
@endsection

@section('profile')
    <div class="dashboard-right-box">
        <div class="address-tab">
            <div class="sidebar-title">
                <div class="loader-line"></div>
                <h4>Ưu đãi</h4>
                <form action="{{ route('profile.myVoucher.create') }}" method="post" class="mt-5 row">
                    @csrf
                    <div class="mb-3 d-flex align-items-center">
                        
                        <input type="text" name="code" id="code" class="form-control me-2"
                            placeholder="Nhập mã giảm giá" >
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                    @error('code')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </form>
            </div>

            <div class="row gy-3">
                @foreach ($data as $item)
                    <div class="col-xxl-4 col-md-6">
                        <div class="address-option">
                            <label for="address-billing-0">
                                <span class="delivery-address-box">
                                    <span class="form-check"></span>
                                    <span class="address-detail">
                                        <span class="address">
                                            <span class="address-title">Loại: {{ $item->voucher->name }}</span>
                                        </span>
                                        <span class="address">
                                            <span class="address-home">
                                                <span class="address-tag">Mã giảm giá:</span> {{ $item->voucher->code }}
                                            </span>
                                        </span>
                                        <span class="address">
                                            <span class="address-home">
                                                <span class="address-tag">Giảm:</span>
                                                @if ($item->voucher->discount_type === 'PERCENTAGE')
                                                    {{ number_format($item->voucher->discount_value, 0) }}%
                                                @else
                                                    {{ number_format($item->voucher->discount_value, 0, ',', '.') }} VND
                                                @endif
                                            </span>
                                        </span>
                                        <span class="address">
                                            <span class="address-home">
                                                <span class="address-tag">Trạng thái:</span>
                                                @if ($item->voucher->status == 'ACTIVE' && $item->voucher->end_date > \Carbon\Carbon::now() && $item->voucher->limit > 0)
                                                    Còn hiệu lực
                                                @else
                                                    Hết hiệu lực
                                                @endif
                                            </span>
                                        </span>

                                        @php
                                            $currentDate = \Carbon\Carbon::now();
                                            $startDate = \Carbon\Carbon::parse($item->voucher->start_date);
                                        @endphp

                                        @if ($currentDate->lt($startDate))
                                            <span class="address">
                                                <span class="address-home">
                                                    <span class="address-tag">Ngày hiệu lực:</span>
                                                    {{ $item->voucher->start_date }}
                                                </span>
                                            </span>
                                        @else
                                            <span class="address">
                                                <span class="address-home">
                                                    <span class="address-tag">Ngày hết hạn:</span>
                                                    {{ $item->voucher->end_date }}
                                                </span>
                                            </span>
                                        @endif

                                        <!-- Modal for voucher details -->

                                    </span>

                                </span>
                                <div class="text-end mt-1">
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#voucherModal{{ $item->id }}">
                                        Xem chi tiết
                                    </button>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="modal fade" id="voucherModal{{ $item->id }}" tabindex="-1"
                        aria-labelledby="voucherModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="voucherModalLabel{{ $item->id }}">
                                        Chi tiết ưu đãi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <strong>Loại:</strong> {{ $item->voucher->name }}<br>
                                    <strong>Mô tả:</strong> {{ $item->voucher->description }}<br>
                                    <strong>Mã giảm giá:</strong> {{ $item->voucher->code }}<br>
                                    <strong>Giảm:</strong>
                                    @if ($item->voucher->discount_type === 'PERCENTAGE')
                                        {{ number_format($item->voucher->discount_value, 0) }}%
                                    @else
                                        {{ number_format($item->voucher->discount_value, 0, ',', '.') }} VND
                                    @endif
                                    <br>
                                    <strong>Áp dụng cho đơn:</strong>
                                    {{ number_format($item->voucher->min_order_value) . ' - ' . number_format($item->voucher->max_order_value) . ' VND' }}<br>
                                    <strong>Trạng thái:</strong>
                                    @if ($item->voucher->status == 'ACTIVE' && $item->voucher->end_date > \Carbon\Carbon::now() && $item->voucher->limit > 0)
                                        Còn hiệu lực
                                    @else
                                        Hết hiệu lực
                                    @endif
                                    <br>
                                    <strong>Ngày hiệu lực:</strong> {{ $item->voucher->start_date }}<br>
                                    <strong>Ngày hết hạn:</strong> {{ $item->voucher->end_date }}<br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
