@extends('client.pages.profile.layouts.master')

@section('title')
    Chi tiết đơn hàng
@endsection

@section('profile')
    <style>
        .rating {
            list-style: none;
            padding: 0;
            display: flex;
            align-items: center;
            /* Căn giữa các sao với số lượng */
        }

        .rating li {
            margin-right: 5px;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
        }

        .rating input:checked+label,
        .rating input:checked~label {
            color: #f39c12;
        }

        .rating span {
            font-size: 16px;
            /* Cỡ chữ cho số sao */
            margin-left: 10px;
            /* Khoảng cách giữa sao và số lượng */
        }
    </style>
    <div class="dashboard-right-box">
        <div class="order">
            <div class="sidebar-title">
                <div class="loader-line"></div>
                <h4>Chi tiết đơn hàng</h4>
            </div>
            <div class="row gy-4">
                <div class="col-12">
                    <div class="order-box">
                        <div class="order-container">
                            <div class="order-icon">
                                <i class="iconsax" data-icon="box"></i>
                                <div class="couplet">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                            </div>
                            <div class="order-detail">
                                @php
                                    // Danh sách các trạng thái và tên tab tương ứng
                                    $tabs = [
                                        'PROCESSING' => 'Chờ thanh toán',
                                        'PENDING' => 'Đang chờ xử lý',
                                        'DELIVERING' => 'Đang giao hàng',
                                        'SHIPPED' => 'Đã giao hàng',
                                        'COMPLETED' => 'Thành công',
                                        'CANCELED' => 'Hủy đơn hàng',
                                        'REFUND' => 'Hoàn hàng',
                                    ];
                                    $statusText = $tabs[$order->status] ?? 'Không xác định';
                                @endphp
                                <h5>Trạng thái: {{ $statusText }}</h5>
                                <p>Ngày giao: {{ date('D, d M', strtotime($order->delivery_date)) }}</p>
                            </div>
                        </div>
                        <div class="product-order-detail">
                            @foreach ($order->orderItems as $item)
                                <div class="product-box">
                                    <a href="{{ route('product', $item->productVariant->product->id) }}">
                                        <img src="{{ '/storage/' . $item->productVariant->product->image }}"
                                            alt="{{ $item->productVariant->product->name }}" />
                                    </a>
                                    <div class="order-wrap">
                                        <h5>{{ $item->product_name }}</h5>
                                        <p>{{ $order->note }}</p>
                                        <ul>
                                            <li>
                                                <p>Giá:</p>
                                                <span>{{ number_format($item->product_price) }} Vnd</span>
                                            </li>
                                            <li>
                                                <p>Số lượng:</p>
                                                <span>{{ $item->quantity }}</span>
                                            </li>
                                            <li>
                                                <p>Biến thể:</p>
                                                <span>{{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }}</span>
                                            </li>
                                            <li>
                                                <p>Mã đơn hàng:</p>
                                                <span>{{ $order->id }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="return-box">
                                    <div class="review-box">
                                        <ul class="rating">
                                            @if ($order->status === 'COMPLETED' && $order->confirm_status === 'ACTIVE')
                                                @php
                                                    $rating = $item->feedback ? $item->feedback->rating : 0; // Lấy rating từ feedback
                                                @endphp
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <li>
                                                        <i class="fa-solid fa-star"
                                                            style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                                                    </li>
                                                @endfor
                                                <span>{{ number_format($rating, 1) }} / 5 sao</span>
                                                <!-- Hiển thị số sao trung bình -->
                                            @endif
                                        </ul>
                                        @if ($order->status === 'COMPLETED' && $order->confirm_status === 'ACTIVE')
                                            @if ($item->feedback)
                                                <span>Cảm ơn bạn đã mua sản phẩm của chúng tôi</span>
                                            @else
                                                <span data-bs-toggle="modal" data-bs-target="#Reviews-modal"
                                                    title="Đánh giá" tabindex="0">Viết đánh giá</span>
                                                @include('client.pages.profile.layouts.components.rating-product')
                                            @endif
                                        @else
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            @if ($order->confirm_status === 'IN_ACTIVE' && $order->status === 'SHIPPED')
                                <div class="mt-3 text-center">
                                    <form action="{{ route('profile.order.confirmstatus', $order->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button style="background-color: #c28f51; border:none;" type="submit"
                                            class="btn btn-danger">Đã nhận hàng</button>
                                    </form>
                                </div>
                            @endif
                            @if ($order->confirm_status === 'IN_ACTIVE' && $order->status === 'PROCESSING')
                                <div class="mt-3 text-center">
                                    <button style="background-color: #c28f51; border:none;" type="button"
                                        class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#CancelOrderModal">Xóa
                                        đơn hàng</button>
                                    <button style="background-color: #c28f51; border:none;" type="submit"
                                        class="btn btn-danger">Tiếp tục thanh toán</button>
                                </div>
                                <!-- Modal xác nhận xóa đơn hàng -->
                                <div class="modal fade" id="CancelOrderModal" tabindex="-1"
                                    aria-labelledby="CancelOrderModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="CancelOrderModalLabel">Xác nhận xóa đơn hàng
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn xóa đơn hàng này?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Đóng</button>
                                                <form action="{{ route('profile.order.delete', $order->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- trạng thái hoàn hàng -->
                            @if ($order->status === 'REFUND')
                                @php
                                    $refundItemStatus = [
                                        'PENDING' => ' Đang chờ phê duyệt',
                                        'APPROVED' => ' Đã được phê duyệt',
                                        'REJECTED' => 'Bị từ chối',
                                    ];
                                    $refundItemReason = [
                                        'NOT_RECEIVED' => 'Chưa nhận được hàng',
                                        'MISSING_ITEMS' => 'Thiếu sản phẩm',
                                        'DAMAGED_ITEMS' => 'Sản phẩm bị hư hỏng',
                                        'INCORRECT_ITEMS' => 'Sản phẩm không đúng',
                                        'FAULTY_ITEMS' => 'Sản phẩm bị lỗi',
                                        'DIFFERENT_FROM_DESCRIPTION' => 'Sản phẩm khác mô tả',
                                        'USED_ITEMS' => 'Sản phẩm đã qua sử dụng',
                                    ];

                                @endphp
                                @foreach ($order->refund as $refund)
                                    <h5>Thông tin hoàn hàng:</h5>
                                    @foreach ($refund->refundItem as $item)
                                        <div class="mb-3">
                                            <p>Sản phẩm hoàn trả:
                                                {{ $item->productVariant->product->name }}
                                                ({{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }})
                                            </p>
                                            <p>Số lượng hoàn: {{ $item->quantity }}</p>
                                            <p>Lý do:
                                                {{ $refundItemReason[$item->reason] }}
                                            </p>
                                            <p>Mô tả chi tiết: {{ $item->description }}</p>
                                            <img width="100px" height="120px" src="{{ '/storage/' . $item->img }}"
                                                alt="" />
                                            <p>Trạng thái: {{ $refundItemStatus[$item->status] }}</p>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                            <!-- Nút hủy đơn hàng -->
                            @if ($order->status === 'PENDING')
                                <div class="mt-3 text-center">
                                    <!-- Nút hủy đơn hàng -->
                                    <button style="background-color: #c28f51; border:none;" type="button"
                                        class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#CancelOrderModal">Hủy
                                        đơn hàng</button>
                                </div>
                                <!-- Modal xác nhận hủy đơn hàng -->
                                <div class="modal fade" id="CancelOrderModal" tabindex="-1"
                                    aria-labelledby="CancelOrderModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="CancelOrderModalLabel">Xác nhận hủy đơn hàng
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Bạn có chắc chắn muốn hủy đơn hàng này? Lý do hủy:
                                                <!-- Form nhập lý do hủy -->
                                                <form action="{{ route('profile.order.cancel', $order->id) }}"
                                                    method="POST" id="cancelOrderForm">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="form-group mt-3">
                                                        <label for="cancel_reason">Chọn lý do hủy đơn hàng:</label><br>
                                                        <input type="radio" name="cancel_reason" id="wrong_product"
                                                            value="wrong_product">
                                                        <label for="wrong_product">Sản phẩm sai</label><br>

                                                        <input type="radio" name="cancel_reason" id="change_of_mind"
                                                            value="change_of_mind">
                                                        <label for="change_of_mind">Thay đổi ý định</label><br>

                                                        <input type="radio" name="cancel_reason" id="price_too_high"
                                                            value="price_too_high">
                                                        <label for="price_too_high">Giá quá cao</label><br>

                                                        <input type="radio" name="cancel_reason" id="payment_issue"
                                                            value="payment_issue">
                                                        <label for="payment_issue">Vấn đề thanh toán</label><br>

                                                        <input type="radio" name="cancel_reason" id="long_wait_time"
                                                            value="long_wait_time">
                                                        <label for="long_wait_time">Chờ lâu</label><br>

                                                        <input type="radio" name="cancel_reason" id="other"
                                                            value="other">
                                                        <label for="other">Khác</label>
                                                    </div>

                                                    <div class="form-group mt-3" id="other_reason_box"
                                                        style="display: none;">
                                                        <label for="cancel_reason_other">Lý do khác:</label>
                                                        <input type="text" name="cancel_reason_other"
                                                            id="cancel_reason_other" class="form-control" />
                                                        @error('cancel_reason_other')
                                                            <div class="text-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-danger">Xác nhận
                                                            hủy</button>
                                                    </div>
                                                </form>

                                                @error('cancel_reason')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Script để hiển thị ô nhập lý do khi chọn "Khác" -->
                                <script>
                                    document.querySelectorAll('input[name="cancel_reason"]').forEach(function(radio) {
                                        radio.addEventListener('change', function() {
                                            var otherReasonBox = document.getElementById('other_reason_box');
                                            var cancelReasonOtherInput = document.getElementById('cancel_reason_other');

                                            if (this.value === 'other') {
                                                otherReasonBox.style.display = 'block'; // Hiển thị ô nhập lý do khác
                                            } else {
                                                otherReasonBox.style.display = 'none'; // Ẩn ô nhập lý do khác
                                                cancelReasonOtherInput.value = ''; // Xóa nội dung đã nhập trong ô "Khác"
                                            }
                                        });
                                    });
                                </script>
                            @endif

                        </div>
                        <div class="mt-3 text-center">
                            <a style="background-color: #c28f51; border:none;"
                                href="{{ route('profile.order-history') }}" class="btn btn-primary">Lịch sử đơn hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
