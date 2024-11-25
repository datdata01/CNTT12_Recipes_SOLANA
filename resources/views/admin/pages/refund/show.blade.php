<div class="modal fade" id="refundDetailModal-{{ $list->id }}" tabindex="-1" role="dialog"
    aria-labelledby="refundDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex">
                <h5 class="modal-title" id="refundDetailModalLabel">Chi tiết hoàn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5 overflow-hidden d-flex justify-content-center align-items-center">
                        <img src="{{ asset('storage/' . $list->image) }}" class="img-thumbnail w-100"
                            alt="Image of refund">
                    </div>
                    <div class="col-sm-7">
                        <div>
                            <strong>Mã đơn hàng: </strong>
                            <label>{{ $list->order->code ?? 'Không có mã order_id' }}</label>
                        </div>
                        <div>
                            <strong>Địa chỉ: </strong>
                            <label>{{ $list->order->full_address ?? 'Không có địa chỉ' }}</label>
                        </div>
                        <div>
                            <strong>Lý do: </strong>
                            <label>
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
                                {{ $reasonText }}
                            </label>
                        </div>
                        <div>
                            <strong>Mô tả: </strong>
                            <label>{{ $list->description }}</label>
                        </div>
                        <div>
                            <strong>Trạng thái: </strong>
                            <label>
                                @if ($list->status == 'ORDER_CREATED')
                                    <span class="badge bg-warning">Tạo đơn thành công</span>
                                @elseif ($list->status == 'CANCEL_REFUND_ORDER')
                                    <span class="badge bg-danger">Hủy đơn hoàn</span>
                                @elseif ($list->status == 'HANDOVER_TO_SHIPPING')
                                    <span class="badge bg-info">Giao cho đơn vị vận chuyển</span>
                                @elseif ($list->status == 'REFUND_COMPLETED')
                                    <span class="badge bg-success">Đã hoàn hàng thành công</span>
                                @elseif ($list->status == 'DELIVERY_FAILED')
                                    <span class="badge bg-secondary">Giao hàng thất bại</span>
                                @else
                                    <span class="badge bg-danger">Không xác định</span>
                                @endif
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
