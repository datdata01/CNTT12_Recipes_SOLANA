<!-- resources/views/admin/pages/refund/refund_detail_modal.blade.php -->
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
                            <strong>Order ID: </strong>
                            <label>{{ $list->order->id ?? 'Không có mã order_id' }}</label>
                        </div>
                        <div>
                            <strong>Lý do: </strong>
                            <label>{{ $list->reason }}</label>
                        </div>
                        <div>
                            <strong>Mô tả: </strong>
                            <label>{{ $list->description }}</label>
                        </div>
                        <div>
                            <strong>Trạng thái: </strong>
                            <label>
                                @if ($list->status == 'PENDING')
                                    <span class="badge bg-warning">Đang chờ</span>
                                @elseif ($list->status == 'COMPLETED')
                                    <span class="badge bg-success">Hoàn thành</span>
                                @else
                                    <span class="badge bg-danger">Không thành công</span>
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
