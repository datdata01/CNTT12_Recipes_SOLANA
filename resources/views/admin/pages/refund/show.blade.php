<div class="modal fade" id="refundDetailModal-{{ $order->id }}" tabindex="-1" role="dialog"
    aria-labelledby="refundDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 50%;" role="document">
        <div class="modal-content">
            <form action="{{ route('refund.update', $refund->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Đảm bảo dùng PUT để tuân thủ chuẩn RESTful -->
                <div class="modal-header d-flex">
                    <h5 class="modal-title" id="refundDetailModalLabel">Cập nhật trạng thái chi tiết hoàn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div>
                                <strong>Trạng thái đơn hoàn hàng:</strong>
                                <select name="refund_status" class="form-control">
                                    <option value="PENDING" {{ $refund->status == 'PENDING' ? 'selected' : '' }}>
                                        Chờ phê duyệt
                                    </option>
                                    <option value="APPROVED" {{ $refund->status == 'APPROVED' ? 'selected' : '' }}>
                                        Đã phê duyệt
                                    </option>
                                    <option value="IN_TRANSIT" {{ $refund->status == 'IN_TRANSIT' ? 'selected' : '' }}>
                                        Đang vận chuyển
                                    </option>
                                    <option value="COMPLETED" {{ $refund->status == 'COMPLETED' ? 'selected' : '' }}>
                                        Hoàn tất
                                    </option>
                                </select>
                            </div>
                            <div class="mt-3">
                                <h3 class="text-center">Chi tiết đơn hàng:</h3>
                                <div>
                                    <strong>Mã đơn hàng: </strong>
                                    <span>{{ $order->code ?? 'Không có mã order_id' }}</span>
                                </div>
                                <div>
                                    <strong>Địa chỉ: </strong>
                                    <span>{{ $order->full_address ?? 'Không có địa chỉ' }}</span>
                                </div>
                                <div>
                                    <strong>Khách hàng: </strong>
                                    <span>{{ $order->customer_name }}</span>
                                </div>
                                <div>
                                    <strong>Liên hệ: </strong>
                                    <span>{{ $order->phone }}</span>
                                </div>
                            </div>
                            @foreach ($order->orderItems as $item)
                                <div class="d-flex mt-3 rounded border p-2">
                                    <div class="product-img mr-3">
                                        <a href="{{ route('product', $item->productVariant->product->id) }}">
                                            <img width="100px" height="120px"
                                                src="{{ '/storage/' . $item->productVariant->product->image }}"
                                                alt="{{ $item->productVariant->product->name }}" />
                                        </a>
                                    </div>
                                    <div class="product-bo">
                                        <div>
                                            <strong>Tên sp: </strong>
                                            <span>
                                                {{ $item->product_name }}({{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }})
                                            </span>
                                        </div>
                                        <strong>{{ $order->note }}</strong>
                                        <div>
                                            <strong>Giá: </strong>
                                            <span>{{ number_format($item->product_price) }} Vnd</span>
                                        </div>
                                        <div>
                                            <strong>Số lượng: </strong>
                                            <span>{{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <h3 class="text-center">Chi tiết đơn hoàn hàng:</h3>
                            @foreach ($refund->refundItem as $refundItem)
                                <div class="mt-3 rounded border p-2">
                                    <div>
                                        <strong>Sản phẩm hoàn trả:</strong>
                                        <label>
                                            {{ $refundItem->productVariant->product->name }}
                                            ({{ $refundItem->productVariant->attributeValues->pluck('name')->implode(' - ') }})
                                        </label>
                                    </div>
                                    <div>
                                        <strong>Số lượng hoàn:</strong>
                                        <label>{{ $refundItem->quantity }}</label>
                                    </div>
                                    <div>
                                        <strong>Lý do:</strong>
                                        <label>
                                            {{ match ($refundItem->reason) {
                                                'NOT_RECEIVED' => 'Chưa nhận được hàng',
                                                'MISSING_ITEMS' => 'Thiếu sản phẩm',
                                                'DAMAGED_ITEMS' => 'Sản phẩm bị hư hỏng',
                                                'INCORRECT_ITEMS' => 'Sản phẩm không đúng',
                                                'FAULTY_ITEMS' => 'Sản phẩm có lỗi',
                                                'DIFFERENT_FROM_DESCRIPTION' => 'Khác với mô tả',
                                                'USED_ITEMS' => 'Sản phẩm đã qua sử dụng',
                                                default => 'Không xác định',
                                            } }}
                                        </label>
                                    </div>
                                    <div>
                                        <strong>Mô tả chi tiết:</strong>
                                        <label>{{ $refundItem->description }}</label>
                                    </div>
                                    <img width="100px" height="120px" src="{{ '/storage/' . $refundItem->img }}"
                                        alt="" />
                                    <div class="mt-2">
                                        <strong>Trạng thái:</strong>
                                        <select name="statuses[{{ $refundItem->id }}]" class="form-control">
                                            <option value="PENDING"
                                                {{ $refundItem->status == 'PENDING' ? 'selected' : '' }}>Chờ phê duyệt
                                            </option>
                                            <option value="APPROVED"
                                                {{ $refundItem->status == 'APPROVED' ? 'selected' : '' }}>Đã được phê
                                                duyệt</option>
                                            <option value="REJECTED"
                                                {{ $refundItem->status == 'REJECTED' ? 'selected' : '' }}>Bị từ chối
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Cập nhật</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
