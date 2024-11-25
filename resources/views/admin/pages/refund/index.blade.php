@extends('admin.layouts.master')
@section('title')
Danh sách hoàn hàng
@endsection
@section('content')
<div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Danh sách hoàn hàng</strong>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                    <a class="btn btn-success" href="{{ route('refund.create') }}">Thêm mới</a>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Mô tả chi tiết</th>
                            <th scope="col">Lý do hoàn hàng</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listRefund as $index => $list)
                                                <tr>
                                                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                                    <td class="text-center">{{ $list->order->code ?? 'Không có mã order_id' }}</td>
                                                    <td class="text-center">
                                                        <img src="{{ asset('storage/' . $list->image) }}" alt="" width="100px" height="100px">
                                                    </td>
                                                    <td class="text-center">{{ $list->description }}</td>
                                                    <td class="text-center">
                                                        @php
                                                            // Xác định lý do hoàn hàng và chuyển đổi thành tiếng Việt
                                                            $reasonText = '';
                                                            switch ($list->reason) {
                                                                case 'NOT_RECEIVED':
                                                                    $reasonText = 'Chưa nhận được hàng';
                                                                    break;
                                                                case 'MISSING_ITEMS':
                                                                    $reasonText = 'Thiếu món hàng';
                                                                    break;
                                                                case 'DAMAGED_ITEMS':
                                                                    $reasonText = 'Hàng hóa bị hư hỏng';
                                                                    break;
                                                                case 'INCORRECT_ITEMS':
                                                                    $reasonText = 'Món hàng không đúng';
                                                                    break;
                                                                case 'FAULTY_ITEMS':
                                                                    $reasonText = 'Hàng hóa bị lỗi';
                                                                    break;
                                                                case 'DIFFERENT_FROM_THE_DESCRIPTION':
                                                                    $reasonText = 'Khác với mô tả';
                                                                    break;
                                                                case 'USED_ITEMS':
                                                                    $reasonText = 'Hàng hóa đã qua sử dụng';
                                                                    break;
                                                                default:
                                                                    $reasonText = 'Không xác định';
                                                                    break;
                                                            }
                                                        @endphp
                                                        <span>{{ $reasonText }}</span>
                                                    </td>

                                                    <td class="text-center">
                                                        @php
                                                            // Xác định trạng thái hoàn hàng và chuyển đổi thành tiếng Việt
                                                            $statusText = '';
                                                            $statusClass = '';
                                                            switch ($list->status) {
                                                                case 'ORDER_CREATED':
                                                                    $statusText = 'Tạo đơn thành công';
                                                                    $statusClass = 'text-warning'; // Màu vàng cho trạng thái chờ
                                                                    break;
                                                                case 'CANCEL_REFUND_ORDER':
                                                                    $statusText = 'Hủy đơn hoàn';
                                                                    $statusClass = 'text-danger'; // Màu đỏ cho trạng thái bị từ chối
                                                                    break;
                                                                case 'HANDOVER_TO_SHIPPING':
                                                                    $statusText = 'Giao cho đơn vị vận chuyển';
                                                                    $statusClass = 'text-info'; // Màu xanh dương cho trạng thái giao hàng
                                                                    break;
                                                                case 'REFUND_COMPLETED':
                                                                    $statusText = 'Đã hoàn hàng thành công';
                                                                    $statusClass = 'text-success'; // Màu xanh cho trạng thái hoàn thành
                                                                    break;
                                                                case 'DELIVERY_FAILED':
                                                                    $statusText = 'Giao hàng thất bại';
                                                                    $statusClass = 'text-secondary'; // Màu xám cho trạng thái giao hàng thất bại
                                                                    break;
                                                                default:
                                                                    $statusText = 'Không xác định';
                                                                    $statusClass = 'text-muted'; // Màu xám cho trạng thái mặc định
                                                                    break;
                                                            }
                                                        @endphp
                                                        <span class="{{ $statusClass }}">{{ $statusText }}</span>
                                                    </td>

                                                    <td class="text-center">

                                                        <a type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#refundDetailModal-{{ $list->id }}">
                                                            <i class="fa fa-info-circle"></i>
                                                        </a>
                                                        <a href="{{ route('refund.edit', $list->id) }}" class="btn btn-warning">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @include('admin.pages.refund.show')
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $listRefund->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
