<script>
$(document).ready(function() {
    // Lắng nghe sự kiện khi người dùng nhấn nút Áp dụng
    $(document).on('click', '#apply', function() {
        var couponCode = $('#voucher-code-input').val().trim();
        var userId = $('#user-id').val();

        // Kiểm tra mã giảm giá trống
        if (!couponCode) {
            alert('Vui lòng nhập mã giảm giá.');
            return;
        }

        $.ajax({
            url: '/api/voucher/check',
            type: 'POST',
            data: {
                coupon_code: couponCode,
                user_id: userId,
            },
            success: function(response) {
                if (response.status !== 'valid') {
                    alert(response.message);
                    return;
                }

                const totalAmount = parseFloat($('input[name="totalAmount"]').val());
                const minAmount = parseFloat(response.data.min_order_value);
                const maxAmount = parseFloat(response.data.max_order_value);

                if (totalAmount < minAmount || totalAmount > maxAmount) {
                    alert(
                        `Mã giảm giá chỉ áp dụng cho tổng giá từ ${minAmount.toLocaleString()} VND đến ${maxAmount.toLocaleString()} VND.`
                    );
                    return;
                }

                // Hiển thị thông tin mã giảm giá
                $('#coupon-display').show();
                $('#coupon-name').text(response.data.name);
                $('#voucher-id-input').val(response.data.id);

                if (response.usage && response.usage.id) {
                    $('#id-input').val(response.usage.id);
                }

                // Tính giảm giá
                let discountAmount = 0;
                if (response.data.discount_type === 'PERCENTAGE') {
                    discountAmount = (response.data.discount_value / 100) * totalAmount;
                    if (discountAmount > response.data.max_discount) {
                        discountAmount = response.data.max_discount;
                    }
                } else {
                    discountAmount = response.data.discount_value;
                    if (totalAmount <= discountAmount) discountAmount = totalAmount;
                }

                const newTotal = totalAmount - discountAmount;
                $('input[name="discount_amount"]').val(discountAmount);
                $('#discount-amount').text(
                    `- ${Math.round(discountAmount).toLocaleString('vi-VN')} VND`);
                $('input[name="total_amount"]').val(newTotal);
                $('#summary-total').text(`${newTotal.toLocaleString()} VND`);
            },
            error: function(xhr) {
                var errorMessage = (xhr.responseJSON && xhr.responseJSON.message) ||
                    'Có lỗi xảy ra khi kiểm tra mã giảm giá.';
                alert(errorMessage);
            },
        });
    });

    // Xóa thông tin khi input mã giảm giá bị xóa
    $('#voucher-code-input').on('input', function() {
        if ($(this).val().trim() === '') {
            $('#coupon-display').hide();
            $('#coupon-name').text('');
            $('#voucher-id-input').val('');
            $('#id-input').val('');
        }
    });
});

</script>
