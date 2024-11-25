@extends('admin.layouts.master')

@section('title')
Chỉnh sửa hoàn hàng
@endsection

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <strong>Chỉnh sửa hoàn hàng</strong>
        </div>
        <div class="card-body card-block">
            <form action="{{ route('refund.update', $refund->id) }}" method="post" enctype="multipart/form-data"
                class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Khung bên trái: Thông tin về đơn hoàn hàng -->
                    <div class="col-md-6">
                        <!-- Tên người đặt -->
                        <div class="form-group">
                            <label class="form-control-label">Tên người đặt</label>
                            <input type="text" class="form-control" value="{{ $refund->order->customer_name }}"
                                disabled>
                        </div>

                        <!-- Địa chỉ người đặt -->
                        <div class="form-group">
                            <label class="form-control-label">Địa chỉ</label>
                            <textarea class="form-control" disabled>{{ $refund->order->full_address }}</textarea>
                        </div>

                        <!-- Ảnh sản phẩm -->
                        <div class="form-group">
                            <label class="form-control-label">Ảnh sản phẩm</label>
                            <div>
                                <img src="{{ asset('storage/' . $refund->image) }}" alt="Product Image"
                                    class="img-fluid" style="max-width: 100%;">
                            </div>
                        </div>
                    </div>

                    <!-- Khung bên phải: Thay đổi trạng thái hoàn hàng -->
                    <div class="col-md-6">
                        <!-- Lý do hoàn hàng -->
                        <div class="form-group">
                            <label class="form-control-label">Lý do hoàn hàng</label>
                            <input type="text" class="form-control" value="{{ [
                                'NOT_RECEIVED' => 'Chưa nhận được hàng',
                                'MISSING_ITEMS' => 'Thiếu món hàng',
                                'DAMAGED_ITEMS' => 'Hàng hóa bị hư hỏng',
                                'INCORRECT_ITEMS' => 'Sản phẩm không đúng',
                                'FAULTY_ITEMS' => 'Sản phẩm bị lỗi',
                                'DIFFERENT_FROM_DESCRIPTION' => 'Khác với mô tả',
                                'USED_ITEMS' => 'Sản phẩm đã qua sử dụng'
                                ][$refund->reason] ?? 'Lý do không xác định' }}" disabled>
                        </div>

                        <!-- Mô tả hoàn hàng -->
                        <div class="form-group">
                            <label class="form-control-label">Mô tả</label>
                            <textarea class="form-control" disabled>{{ $refund->description }}</textarea>
                        </div>

                        <!-- Trạng thái hoàn hàng hiện tại -->
                        <div class="form-group">
                            <label class="form-control-label">Trạng thái hoàn hàng:
                                <div>
                                    @php
                                        // Mảng trạng thái và màu sắc của chúng
                                        $statusText = [
                                            'ORDER_CREATED' => 'Tạo đơn thành công',
                                            'CANCEL_REFUND_ORDER' => 'Hủy đơn hoàn',
                                            'HANDOVER_TO_SHIPPING' => 'Giao cho đơn vị vận chuyển',
                                            'REFUND_COMPLETED' => 'Đã hoàn hàng thành công',
                                            'DELIVERY_FAILED' => 'Giao hàng thất bại'
                                        ];
                                        $statusColors = [
                                            'ORDER_CREATED' => 'text-warning',  // Màu vàng
                                            'CANCEL_REFUND_ORDER' => 'text-danger',  // Màu đỏ
                                            'HANDOVER_TO_SHIPPING' => 'text-primary',  // Màu xanh dương
                                            'REFUND_COMPLETED' => 'text-success',  // Màu xanh
                                            'DELIVERY_FAILED' => 'text-warning'  // Màu xám
                                        ];

                                        // Kiểm tra trạng thái hiện tại và sử dụng màu sắc và văn bản tương ứng
                                        $currentStatusText = $statusText[$refund->status] ?? 'Trạng thái không xác định';
                                        $currentStatusColor = $statusColors[$refund->status] ?? 'text-muted'; // Màu mặc định nếu không có trạng thái phù hợp
                                    @endphp
                                    <span class="{{ $currentStatusColor }}">
                                        {{ $currentStatusText }}
                                    </span>
                                </div>
                            </label>
                        </div>

                        <!-- Nút thay đổi trạng thái -->
                        @php
                            // Cập nhật mảng trạng thái và trạng thái tiếp theo
                            $nextStatus = [
                                'ORDER_CREATED' => 'HANDOVER_TO_SHIPPING',       // Tạo đơn thành công -> Giao cho đơn vị vận chuyển
                                'HANDOVER_TO_SHIPPING' => 'REFUND_COMPLETED',    // Giao cho đơn vị vận chuyển -> Đã hoàn hàng thành công
                            ][$refund->status] ?? null;
                        @endphp

                        @if($nextStatus && $refund->status !== 'CANCEL_REFUND_ORDER')
                            <form action="{{ route('refund.update', $refund->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $nextStatus }}">
                                <!-- Nút thay đổi trạng thái -->
                                <button type="submit" class="btn btn-outline-primary mt-3">
                                    {{ $statusText[$nextStatus] }}
                                </button>

                                <!-- Nếu trạng thái hiện tại là ORDER_CREATED, cho phép hủy đơn hoàn -->
                                @if ($refund->status == 'ORDER_CREATED')
                                    <button type="submit" class="btn btn-danger mt-3" name="cancel_refund" value="true">
                                        Hủy đơn hoàn
                                    </button>
                                @endif

                                <!-- Nếu trạng thái hiện tại là HANDOVER_TO_SHIPPING, cho phép giao thất bại -->
                                @if ($refund->status == 'HANDOVER_TO_SHIPPING')
                                    <button type="submit" class="btn btn-danger mt-3" name="DELIVERY_FAILED" value="true">
                                        Giao thất bại
                                    </button>
                                @endif
                            </form>
                        @endif

                        <!-- Nút Submit -->
                        <div class="form-actions form-group mt-4">
                            <a href="{{ route('refund.index') }}" class="btn btn-primary btn-sm">Quay lại</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
