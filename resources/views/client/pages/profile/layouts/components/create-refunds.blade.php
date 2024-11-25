@extends('client.pages.profile.layouts.master')

@section('title')
    Chi tiết đơn hàng
@endsection

@section('profile')
    <div class="dashboard-right-box">
        <div class="order">
            <div class="sidebar-title">
                <div class="loader-line"></div>
                <h4>Hoàn hàng</h4>
            </div>
            <div class="order-detail row">
                <h6>Mã đơn hàng: {{ $order->code }}</h6>
                <h6>Chi tiết sản phẩm trong đơn hàng</h6>
                @foreach ($order->orderItems as $item)
                    <div class="product-box mb-3">
                        <div class="d-flex">
                            <div class="mx-3">
                                <img width="100px" src="{{ '/storage/' . $item->productVariant->product->image }}"
                                    alt="{{ $item->productVariant->product->name }}" />
                            </div>
                            <div>
                                <p>Tên sản phẩm : {{ $item->product_name }}</p>
                                <p>Giá: {{ number_format($item->product_price) }} Vnd</p>
                                <p>Số lượng: {{ $item->quantity }}</p>
                                <p>Biến thể: {{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <h6>Chọn sản phẩm muốn hoàn</h6>
            <div class="d-flex">
                @foreach ($order->orderItems as $item)
                    {{-- @dd($item) --}}
                    <div class="form-check mx-2">
                        <input type="checkbox" class="refund-checkbox" data-id="{{ $item->productVariant->id }}"
                            data-name="{{ $item->product_name }}"
                            data-variant="{{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }}"
                            data-price="{{ number_format($item->product_price) }}" data-quantity="{{ $item->quantity }}">
                        <label class="form-check-label">{{ $item->product_name }}
                            ({{ $item->productVariant->attributeValues->pluck('name')->implode(' - ') }})
                        </label>
                    </div>
                @endforeach
            </div>

            <form action="{{ route('profile.order.store.refunds') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div id="refunds" class="mt-4"></div>
                <div class="mt-3 text-end">
                    <button type="button" id="create-refunds" style="background-color: #c28f51; border:none;"
                        class="btn btn-primary">Tạo</button>
                    <button type="submit" id="submit-refunds" style="background-color: #c28f51; border:none;"
                        class="btn btn-success">Gửi yêu cầu hoàn hàng</button>
                </div>

            </form>

        </div>
        <script>
            document.getElementById('create-refunds').addEventListener('click', function() {
                const selectedItems = document.querySelectorAll('.refund-checkbox:checked');
                const refundsContainer = document.getElementById('refunds');
                const refundItemsInput = document.getElementById('refund-items');

                // Xóa nội dung cũ
                refundsContainer.innerHTML = '';

                if (selectedItems.length === 0) {
                    refundsContainer.innerHTML =
                        '<p class="text-danger">Vui lòng chọn ít nhất một sản phẩm để hoàn.</p>';
                    return;
                }
                // Tạo form cho từng sản phẩm
                selectedItems.forEach((item, index) => {
                    const productVariantId = item.getAttribute('data-id');
                    const productName = item.getAttribute('data-name');
                    const productVariant = item.getAttribute('data-variant');
                    const productPrice = item.getAttribute('data-price');
                    const productQuantity = item.getAttribute('data-quantity');

                    const formHtml = `
                        <div class="refund-form mb-4 p-3 border">
                            <h6>Hoàn sản phẩm: ${productName} (${productVariant})</h6>
                            <p>Giá: ${productPrice} Vnd</p>
                            <input type="hidden" name="refund[${index}][product_variant_id]" value="${productVariantId}">

                            <!-- Lý do hoàn -->
                            <div class="mb-3">
                                <label for="" class="form-label">Lý do hoàn:</label>
                                <select class="form-select" name="refund[${index}][reason]">
                                    <option value="">Vui lòng chọn lý do</option>
                                    <option value="NOT_RECEIVED">Chưa nhận được hàng</option>
                                    <option value="MISSING_ITEMS">Thiếu sản phẩm</option>
                                    <option value="DAMAGED_ITEMS">Sản phẩm bị hư hỏng</option>
                                    <option value="INCORRECT_ITEMS">Sản phẩm không đúng</option>
                                    <option value="FAULTY_ITEMS">Sản phẩm bị lỗi</option>
                                    <option value="DIFFERENT_FROM_DESCRIPTION">Sản phẩm khác mô tả</option>
                                    <option value="USED_ITEMS">Sản phẩm đã qua sử dụng</option>
                                </select>
                                <!-- Hiển thị lỗi nếu có -->
                               <div class="error-message text-danger"></div>
                            </div>

                            <!-- Mô tả chi tiết -->
                            <div class="mb-3">
                                <label for="" class="form-label">Mô tả chi tiết:</label>
                                <textarea class="form-control" name="refund[${index}][description]"></textarea>
                                <!-- Hiển thị lỗi nếu có -->
                                <div class="error-message text-danger"></div>
                            </div>

                            <!-- Số lượng hoàn -->
                            <div class="mb-3">
                                <label for="" class="form-label">Số lượng hoàn:</label>
                                <input type="number" class="form-control" name="refund[${index}][quantity]" max="${productQuantity}" placeholder="Tối đa: ${productQuantity}">
                                <!-- Hiển thị lỗi nếu có -->
                               <div class="error-message text-danger"></div>
                            </div>

                            <!-- Hình ảnh -->
                            <div class="mb-3">
                                <label for="" class="form-label">Hình ảnh:</label>
                                <input type="file" class="form-control" name="refund[${index}][image]">
                                <!-- Hiển thị lỗi nếu có -->
                               <div class="error-message text-danger"></div>
                            </div>
                        </div>
                `;
                    refundsContainer.innerHTML += formHtml;
                });
            });
            document.getElementById('submit-refunds').addEventListener('click', function(e) {
                const refundForms = document.querySelectorAll('.refund-form');
                let isValid = true;
                refundForms.forEach((form) => {

                    // Reset thông báo lỗi
                    form.querySelectorAll('.error-message').forEach((errorDiv) => {
                        errorDiv.textContent = '';
                    });

                    const quantityInput = form.querySelector('input[name*="[quantity]"]');
                    const quantityMax = parseInt(quantityInput.getAttribute('max'), 10);
                    const imageInput = form.querySelector('input[name*="[image]"]');
                    const reasonSelect = form.querySelector('select[name*="[reason]"]');
                    const descriptionInput = form.querySelector('textarea[name*="[description]"]');

                    // Kiểm tra số lượng
                    if (!quantityInput.value || quantityInput.value > quantityMax || quantityInput.value <= 0) {
                        isValid = false;
                        const errorDiv = quantityInput.nextElementSibling; // Lấy thẻ div.error-message kế tiếp
                        errorDiv.textContent = `Số lượng không hợp lệ. Tối đa: ${quantityMax}, tối thiểu: 1.`;
                    }

                    // Kiểm tra lý do
                    if (!reasonSelect.value) {
                        isValid = false;
                        const errorDiv = reasonSelect.nextElementSibling; // Lấy thẻ div.error-message kế tiếp
                        errorDiv.textContent = 'Vui lòng chọn lý do hoàn.';
                    }

                    // Kiểm tra mô tả
                    if (!descriptionInput.value.trim()) {
                        isValid = false;
                        const errorDiv = descriptionInput
                            .nextElementSibling; // Lấy thẻ div.error-message kế tiếp
                        errorDiv.textContent = 'Mô tả không được bỏ trống.';
                    }

                    // Kiểm tra hình ảnh
                    if (!imageInput.files.length) {
                        isValid = false;
                        const errorDiv = imageInput.nextElementSibling; // Lấy thẻ div.error-message kế tiếp
                        errorDiv.textContent = 'Vui lòng tải lên ít nhất một hình ảnh.';
                    } else {
                        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif']; // Các loại ảnh hợp lệ
                        const file = imageInput.files[0]; // Lấy tệp đầu tiên từ input
                        if (!validImageTypes.includes(file.type)) {
                            isValid = false;
                            const errorDiv = imageInput.nextElementSibling; // Lấy thẻ div.error-message kế tiếp
                            errorDiv.textContent = 'Tệp tải lên phải là hình ảnh (JPG, PNG, GIF).';
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });
        </script>
    @endsection
