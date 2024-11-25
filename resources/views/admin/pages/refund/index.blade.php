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
                    <table class="table-bordered table">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Mã đơn hoàn hàng</th>
                                <th class="text-center" scope="col">Giá trị đơn hàng</th>
                                <th class="text-center" scope="col">Khách hàng</th>
                                <th class="text-center" scope="col">Liên hệ</th>
                                <th class="text-center" scope="col">Trạng thái</th>
                                <th class="text-center" scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @foreach ($order->refund as $refund)
                                    <tr>
                                        <td scope="row" class="text-center">
                                            {{ $refund->code ?? 'Không có mã đơn hoàn hàng' }}
                                        </td>
                                        <td class="text-center">{{ number_format($order->total_amount) }}Vnd</td>
                                        <td class="text-center"> {{ $order->customer_name }}</td>
                                        <td class="text-center">{{ $order->phone }}</td>
                                        <td class="text-center">
                                            @php
                                                // Xác định trạng thái hoàn hàng và chuyển đổi thành tiếng Việt
                                                $statusText = '';
                                                $statusClass = '';
                                                switch ($refund->status) {
                                                    case 'PENDING':
                                                        $statusText = 'Đang chờ phê duyệt';
                                                        $statusClass = 'badge bg-warning';
                                                        break;
                                                    case 'APPROVED':
                                                        $statusText = 'Đã được phê duyệt';
                                                        $statusClass = 'badge bg-success';
                                                        break;
                                                    case 'IN_TRANSIT':
                                                        $statusText = 'Đang vận chuyển';
                                                        $statusClass = 'badge bg-primary';
                                                        break;
                                                    case 'COMPLETED':
                                                        $statusText = 'Hoàn tất';
                                                        $statusClass = 'badge bg-success';
                                                        break;
                                                }
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td class="text-center">

                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#refundDetailModal-{{ $order->id }}">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @include('admin.pages.refund.show')
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
