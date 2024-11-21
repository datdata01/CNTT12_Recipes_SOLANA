@extends('client.layouts.master')
@section('title')
    Thanh toán đơn hàng
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Thanh toán đơn hàng',
        'parent' => [
            'route' => '',
            'name' => '',
        ],
    ])
    <section class="section-b-space pt-0">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('place-order-buy-now') }}" method="POST">
            @csrf
            <div class="custom-container container">
                <div class="row">
                    <div class="col-xxl-9 col-lg-8">
                        <div class="left-sidebar-checkout sticky">
                            <div class="address-option">
                                <div class="address-title">
                                    <h4>Địa Chỉ Giao Hàng </h4><a href="#" data-bs-toggle="modal"
                                        data-bs-target="#add-address-modal" title="Quick View" tabindex="0">+ Thêm Mới Địa
                                        Chỉ</a>
                                </div>
                                <div class="row">
                                    {{-- @dd($userAddress) --}}
                                    @foreach ($userAddress as $key => $item)
                                        <div class="col-xxl-4">
                                            {{-- @dd($item->toArray())    --}}
                                            <label for="{{ $key }}">
                                                <span class="delivery-address-box">
                                                    <span class="form-check">
                                                        <input class="custom-radio" value="{{ $item['id'] }}"
                                                            data-value="{{ $key }}" id="{{ $key }}"
                                                            type="radio"
                                                            @if ($item['default'] == 1) checked="checked" @endif
                                                            name="address_user_id">
                                                    </span>
                                                    <span class="address-detail">

                                                        <span class="address">
                                                            <span class="address-title"> Địa chỉ {{ $key + 1 }}</span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag"> Địa chỉ:</span>
                                                                {{ $item->address_detail }},
                                                                {{ $item->ward->name }},
                                                                {{ $item->district->name }},
                                                                {{ $item->province->name }}
                                                            </span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag">Người nhận:</span>
                                                                {{ $item->name }}
                                                            </span>
                                                        </span>
                                                        <span class="address">
                                                            <span class="address-home">
                                                                <span class="address-tag">Sđt:</span>
                                                                {{ $item->phone }}
                                                            </span>
                                                        </span>

                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="payment-options">
                                <h4 class="mb-3">Phương Thức Thanh Toán</h4>
                                <div class="row gy-3">
                                    <div class="col-sm-4">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="cod" type="radio" checked="checked"
                                                value="cod" name="payment_method">
                                            <label for="cod">Thanh toán khi nhận hàng</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="momo" type="radio"
                                                name="payment_method" value="momo">
                                            <label for="momo">Thanh toán qua MOMO</label>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="payment-box">
                                            <input class="custom-radio me-2" id="vnpay" type="radio"
                                                name="payment_method" value="vnpay">
                                            <label for="vnpay">Thanh toán qua VNPAY</label>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="address-option">
                                <textarea name="note" class="form-control" id="" placeholder="Ghi chú đơn hàng" cols="30"
                                    rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-lg-4">
                        <div class="right-sidebar-checkout">
                            <h4>Thanh Toán</h4>
                            <div class="cart-listing">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @include('client.pages.profile.layouts.components.add-address')
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // lay du lieu san pham mua ngay
        const productStorage = JSON.parse(localStorage.getItem('productBuyNow'));
        console.log(productStorage);

        function handleProduct() {
            $.ajax({
                type: "post",
                url: "{{ route('api.product-variant') }}",
                data: productStorage,
                success: function(response) {
                    console.log(response);
                    // console.log(response.vouchers);
                    showProduct(response.productResponse, response.quantity, response.vouchers)
                }
            }).then(() => {
                $(document).ready(function() {
                    // Lắng nghe sự kiện nhấn nút "Áp dụng" trong modal
                    $('.apply-coupon').on('click', function() {
                        // Lấy mã giảm giá từ nút được nhấn
                        const voucherName = $(this).data('voucher-name');
                        // console.log(voucherName);
                        const voucherId = $(this).data('voucher-id');
                        const Id = $(this).data('id');
                        const discountValue = parseFloat($(this).data(
                            'discount-value'));
                        console.log(discountValue);
                        const discountType = $(this).data('discount-type');
                        console.log(discountType);

                        // Hiển thị thẻ mã giảm giá đã áp dụng và ẩn ô input
                        $('#coupon-display').show();
                        $('#coupon-name').text(voucherName);

                        // Cập nhật voucher_id vào input ẩn
                        $('#voucher-id-input').val(voucherId);

                        $('#id-input').val(Id);

                        // Cập nhật giảm giá vào tổng giá
                        const totalAmount = parseFloat($('input[name="totalAmount"]')
                            .val());
                        let discountAmount = 0;

                        if (discountType === 'PERCENTAGE') {
                            discountAmount = (discountValue / 100) * totalAmount;
                        } else {
                            discountAmount = discountValue;
                            if (totalAmount <= discountAmount) {
                                discountAmount = totalAmount;
                            }
                        }

                        const newTotal = totalAmount - discountAmount;

                        // Cập nhật giá trị vào giao diện
                        $('input[name="discount_amount"]').val(discountAmount);
                        $('#discount-amount').text(
                            `- ${discountAmount.toLocaleString()} VND`);

                        // Cập nhật tổng tiền
                        $('input[name="total_amount"]').val(newTotal);
                        $('#summary-total').text(`${newTotal.toLocaleString()} VND`);

                        // Đóng modal sau khi chọn
                        $('#voucherModal').modal('hide');
                    });

                    // Xử lý sự kiện click nút "X" để xoá mã giảm giá
                    $('#remove-coupon').on('click', function(event) {
                        event
                            .preventDefault(); // Ngăn chặn hành động mặc định (reload trang)

                        // Làm trống ô input và ẩn nút mã giảm giá đã áp dụng
                        $('#coupon-name').text('');
                        $('#coupon-display').hide();

                        // Làm trống voucher_id khi xoá mã giảm giá
                        $('#voucher-id-input').val('');

                        $('#id-input').val('');

                        // Cập nhật lại tổng giá khi xoá mã giảm giá
                        const totalAmount = parseFloat($('input[name="totalAmount"]')
                            .val());
                        const discountAmount = 0;
                        const newTotal = totalAmount;

                        // Cập nhật lại tổng tiền
                        $('input[name="discount_amount"]').val(discountAmount);
                        $('#discount-amount').text(
                            `${discountAmount.toLocaleString()} VND`);

                        // Cập nhật lại tổng tiền sau khi xoá giảm giá
                        $('input[name="total_amount"]').val(newTotal);
                        $('#summary-total').text(`${newTotal.toLocaleString()} VND`);

                        // Hiển thị lại ô input mã giảm giá khi xoá
                        $('#coupon-code-input').show();
                    });
                });
            });
        }
        handleProduct();

        function showProduct(productResponse, quantityP, vouchers) {
            let totalAmount = 0;
            const price = parseFloat(productResponse.price); // Giá sản phẩm
            const quantity = quantityP; // Số lượng sản phẩm
            const itemTotal = price * quantity; // Tổng tiền sản phẩm

            // Tính tổng giá
            totalAmount += itemTotal;

            // Bắt đầu tạo HTML cho sản phẩm
            const cartListing = $(".cart-listing");
            const productList = $("<ul></ul>");

            // Tạo mục sản phẩm
            const productItem = $("<li></li>");

            // Tạo phần hình ảnh sản phẩm
            const productImage = $("<img>")
                .attr("width", "60px")
                .attr("src", "/storage/" + productResponse.product.image)
                .attr("alt", "");

            // Tạo phần chi tiết sản phẩm
            const productDetails = $("<div></div>");
            const productName = $("<h6></h6>").text(productResponse.product.name);
            const variantHidden = $("<input>").attr('type', 'hidden').attr('name', 'variant')
                .val(`${productResponse.id}`);
            productDetails.append(productName);
            productDetails.append(variantHidden);

            // Tạo danh sách thuộc tính sản phẩm
            productResponse.attribute_values.forEach(function(variant) {
                const variantDetail = $("<p></p>").html(
                    `${variant.attribute.name}: <span>${variant.name}</span>`
                );
                productDetails.append(variantDetail);
            });

            // Hiển thị số lượng sản phẩm
            const quantityN = $("<p></p>").addClass("fs-6").text(`Số lượng: ${quantity}`);
            const quantityHidden = $("<input>").addClass("fs-6").attr('type', 'hidden').attr('name', 'quantity')
                .val(`${quantity}`);
            productDetails.append(quantityN);
            productDetails.append(quantityHidden);

            // Hiển thị giá của sản phẩm
            const priceN = $("<p></p>").text(price.toLocaleString("vi-VN") + " VND");

            // Thêm hình ảnh, chi tiết và giá vào mục sản phẩm
            productItem.append(productImage, productDetails, $("<div></div>"), priceN);
            productList.append(productItem);

            // Tạo tổng kết giỏ hàng
            const summaryTotal = $("<div></div>").addClass("summary-total");
            const totalList = $("<ul></ul>");
            const totalItem = $("<li></li>");
            const totalLabel = $("<p></p>").text("Tổng giá");
            const totalHiddenInput = $("<input>").attr("type", "hidden").attr("name", "totalAmount").val(
                totalAmount);
            const totalAmountText = $("<span></span>").text(totalAmount.toLocaleString("vi-VN") + " VND");

            totalItem.append(totalLabel, totalHiddenInput, totalAmountText);
            totalList.append(totalItem);
            summaryTotal.append(totalList);

            //giam gia
            const discountLi = $('<li></li>')
                .append('<p>Giảm giá</p>')
                .append('<input type="hidden" name="discount_amount" value="0">')
                .append('<span id="discount-amount">0 VND</span>');
            totalList.append(discountLi);
            summaryTotal.append(totalList);
            // Hiển thị tổng số tiền
            const totalDiv = $("<div></div>").addClass("total");
            const totalText = $("<h6></h6>").text("Thành tiền : ");
            const totalAmountTextFinal = $("<h6></h6>").attr('id', "summary-total").text(totalAmount
                .toLocaleString("vi-VN") + " VND");
            const hiddenTotalInput = $("<input>").attr("type", "hidden").attr("name", "total_amount").val(
                totalAmount);
            totalDiv.append(totalText, totalAmountTextFinal, hiddenTotalInput);

            // Tạo nút đặt hàng
            const orderButtonDiv = $("<div></div>").addClass("order-button");
            const orderButton = $("<button></button>")
                .attr("type", "submit")
                .addClass("btn btn_black sm w-100 rounded")
                .text("Đặt hàng");
            orderButtonDiv.append(orderButton);
            // tạo vourcher 

            // Tạo các phần tử HTML bằng jQuery
            const couponBox = $("<div>").addClass("coupon-box");

            // Tạo tiêu đề "Mã giảm giá"
            const title = $("<h6>").text("Mã giảm giá");
            couponBox.append(title);

            // Tạo phần hiển thị mã giảm giá
            const couponDisplay = $("<div>")
                .attr("id", "coupon-display")
                .addClass("mb-2")
                .css("display", "none");

            const couponContent = $("<div>")
                .addClass(
                    "border border-success rounded shadow-sm p-2 bg-light d-flex justify-content-between align-items-center"
                );

            const couponNameDiv = $("<div>").append(
                $("<strong>")
                .attr("id", "coupon-name")
                .addClass("text-dark")
                .text("Tên mã ở đây")
            );

            const removeCouponButton = $("<button>")
                .attr("id", "remove-coupon")
                .addClass("btn btn-danger btn-sm")
                .css("font-size", "14px")
                .text("X");

            couponContent.append(couponNameDiv, removeCouponButton);
            couponDisplay.append(couponContent);
            couponBox.append(couponDisplay);

            // Tạo phần nhập mã giảm giá và nút chọn
            const ul = $("<ul>");
            const li = $("<li>");

            const span = $("<span>");
            const input = $("<input>")
                .attr("type", "text")
                .attr("id", "coupon-code-input")
                .attr("placeholder", "Sử dụng mã giảm giá");

            const icon = $("<i>")
                .addClass("iconsax me-1")
                .attr("data-icon", "tag-2");

            const selectButton = $("<button>")
                .attr("type", "button")
                .css({
                    "font-size": "14px",
                    padding: "5px",
                    width: "107px"
                })
                .addClass("btn w-50%")
                .attr("data-bs-toggle", "modal")
                .attr("data-bs-target", "#voucherModal")
                .text("Chọn");

            span.append(input, icon);
            li.append(span, selectButton);
            ul.append(li);
            couponBox.append(ul);

            // Tạo input ẩn để lưu voucher_id
            const hiddenInput = $("<input>")
                .attr("type", "hidden")
                .attr("id", "voucher-id-input")
                .attr("name", "voucher_id")
                .attr("value", "");

            const hiddenInputUsage = $("<input>")
                .attr("type", "hidden")
                .attr("id", "id-input")
                .attr("name", "id_voucherUsage")
                .attr("value", "");

            couponBox.append(hiddenInput,hiddenInputUsage);

            // tạo modal
            const modalHtml = `
            <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <!-- Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="voucherModalLabel">Mã giảm giá</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Body -->
                        <div class="modal-body">
                            <div class="container">
                                <div class="row" id="voucher-list">
                                    <!-- Nội dung voucher sẽ được chèn ở đây -->
                                </div>
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>`;
            couponBox.append(modalHtml);

            // Thêm tất cả vào giỏ hàng
            cartListing.append(productList, couponBox, summaryTotal, totalDiv, orderButtonDiv);
            // Chèn dữ liệu từ vouchers vào trong modal
            vouchers.forEach(item => {
                const voucher = item.voucher;
                const discountValue = voucher.discount_type === 'PERCENTAGE' ?
                    `${parseInt(voucher.discount_value)}%` :
                    `${parseFloat(voucher.discount_value).toLocaleString('vi-VN')} VND`;

                const voucherHtml = `
                <div class="col-6 mb-3">
                    <div class="border border-primary rounded shadow-sm p-3 bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <strong class="text-dark">${voucher.name}</strong>
                            <p class="mb-0">Giảm: ${discountValue}</p>
                        </div>
                        <button type="button" class="btn btn-primary apply-coupon" 
                            data-voucher-name="${voucher.name}"
                            data-id="${item.id}"
                            data-voucher-id="${voucher.id}"
                            data-discount-value="${voucher.discount_value}"
                            data-discount-type="${voucher.discount_type}">
                            Áp dụng
                        </button>
                    </div>
                </div>`;

                $("#voucher-list").append(voucherHtml);
            });
        }





        // lay dia chi them moi
        $('#provinceAdd').change(function() {
            var provinceId = $(this).val();
            if (provinceId) {
                var url = `{{ route('api.districts', ['province_id' => ':province_id']) }}`;
                url = url.replace(':province_id', provinceId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#districtAdd').empty().append(
                            '<option value="">Chọn Huyện/Quận</option>');
                        $('#wardAdd').empty().append(
                            '<option value="">Chọn Xã/Phường</option>');
                        $.each(data, function(key, value) {
                            $('#districtAdd').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
        $('#districtAdd').change(function() {
            var districtId = $(this).val();
            if (districtId) {
                var url = `{{ route('api.wards', ['district_id' => ':district_id']) }}`;
                url = url.replace(':district_id', districtId);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#wardAdd').empty().append(
                            '<option value="">Chọn Xã/Phường</option>');
                        $.each(data, function(key, value) {
                            $('#wardAdd').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
