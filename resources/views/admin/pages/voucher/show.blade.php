<div class="modal fade" id="voucherDetailModal-{{ $voucher->id }}" tabindex="-1" role="dialog"
    aria-labelledby="voucherDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header d-flex">
                    <h5 class="modal-title" id="voucherDetailModalLabel">Chi tiết phiếu giảm giá</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-control-label">Tên loại voucher</label>
                                <input type="text" class="form-control" value="{{ $voucher->name }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-control-label">Mã voucher</label>
                                <input type="text" class="form-control" value="{{ $voucher->code }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-control-label">Ngày bắt đầu</label>
                                <input type="datetime-local" class="form-control" value="{{ $voucher->start_date }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-control-label">Ngày kết thúc</label>
                                <input type="datetime-local" class="form-control" value="{{ $voucher->end_date }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-control-label">Số lượng voucher</label>
                                <input type="text" class="form-control" value="{{ $voucher->limit }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-control-label">Loại voucher</label>
                                <input type="text" class="form-control"
                                    value="{{ $voucher->type === 'SUCCESS' ? 'Áp dụng khi mua hàng thành công' : ($voucher->type === 'FIXED' ? 'Áp dụng cho khách hàng mới' : 'Khác') }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="" class="form-control-label">Kiểu giảm giá</label>
                                <input type="text" class="form-control"
                                    value="{{ $voucher->discount_type === 'percentage' ? 'Giảm theo giá trị phần trăm' : 'Giảm theo giá cố định' }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-control-label">Giá trị giảm</label>
                                <input type="text" class="form-control" value="{{ $voucher->discount_value }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-control-label">Giá trị đơn hàng tối thiểu</label>
                                <input type="text" class="form-control" value="{{ $voucher->min_order_value }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-control-label">Giá trị đơn hàng tối đa</label>
                                <input type="text" class="form-control" value="{{ $voucher->max_order_value }}"
                                    readonly>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-control-label">Trạng thái</label>
                                <input type="text" class="form-control"
                                    value="{{ $voucher->status === 'ACTIVE' ? 'Hoạt động' : 'Không hoạt động' }}"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-control-label">Mô tả thêm về voucher</label>
                                <input type="text" class="form-control" value="{{ $voucher->description }}"
                                    readonly>
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
</div>
