@extends('client.layouts.master')
@section('title', 'Chính sách thanh toán')

@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Chính sách thanh toán',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ])
    <style>
        /* Tùy chỉnh giao diện */
        .contact-main {
            padding: 40px;
        }

        ul {
            padding-left: 20px;

        }

        ul li {
            margin-bottom: 10px;
            list-style-type: disc;
        }

        p {
            margin-bottom: 15px;
        }

        h5 {
            color: #333f48;
            font-weight: bold;

            line-height: normal;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";

        }
    </style>
    <section class="section-b-space pt-0">
        <div class="container">
            <div class="contact-main">
                <a href="">
                    <h2>Chính sách thanh toán</h2>
                </a>
                <p>Nhằm mang đến cho quý khách hàng những trải nghiệm mua sắm hoàn hảo nhất tại GUNDAM WIN. Shop có 3 hình
                    thức thanh toán để quý khách dễ dàng lựa chọn:</p>
                <h5>1/ Mua Hàng thanh toán bằng phương thức COD (thanh toán khi nhận hàng)</h5>
                <p><strong>Thanh toán linh hoạt:</strong> Bạn không phải thanh toán trước mà chỉ thanh toán khi nhận hàng,
                    giúp bạn an tâm hơn về chất lượng sản phẩm.</p>

                <p><strong>Không cần thẻ ngân hàng:</strong> Phương thức này không yêu cầu bạn sử dụng thẻ tín dụng hay ví
                    điện tử, phù hợp với những người không quen sử dụng phương thức thanh toán điện tử.</p>

                <p><strong>Đảm bảo an toàn:</strong> Bạn chỉ thanh toán sau khi nhận được sản phẩm, đảm bảo không gặp phải
                    tình trạng không nhận được hàng hoặc hàng không đúng như mô tả.</p>

                <strong>
                    <h5>Lưu ý:</h5>
                </strong>
                <ul>

                    <li><strong>Kiểm tra thông tin giao hàng:</strong> Đảm bảo bạn cung cấp thông tin địa chỉ chính xác
                        để tránh việc giao hàng bị trễ hoặc thất lạc.</li><br>

                    <li><strong>Sẵn sàng thanh toán khi nhận hàng:</strong> Đảm bảo bạn có đủ tiền mặt khi nhân viên giao
                        hàng đến.</li>

                </ul>
                <h5>2/ Mua Hàng thanh toán bằng MOMO</h5>
                <p><strong>Thanh toán nhanh chóng:</strong> Bạn có thể sử dụng ví điện tử MOMO để thanh toán ngay sau khi
                    hoàn tất đơn hàng trên website của chúng tôi.</p>

                <p><strong>Quy trình thanh toán:</strong> Sau khi chọn phương thức MOMO, bạn sẽ được chuyển đến ứng dụng
                    MOMO trên điện thoại để thực hiện thanh toán. Chỉ cần nhập mã OTP và hoàn tất giao dịch là đơn hàng của
                    bạn sẽ được xử lý.</p>

                <p><strong>Điều kiện áp dụng:</strong> Thanh toán qua MOMO áp dụng cho tất cả các đơn hàng có giá trị trên
                    website, và phí giao dịch (nếu có) sẽ được thông báo rõ ràng.</p>

                <h5>Lưu ý:</h5>

                <ul>
                    <li><strong>Đảm bảo tài khoản MOMO của bạn có đủ số dư:</strong> Trước khi thanh toán, hãy kiểm tra tài khoản MOMO để tránh giao dịch thất bại.</li>
                </ul>

                <h5>3/ Mua Hàng thành toán bằng VNPAY</h5>
                <p><strong>Thanh toán qua VNPAY:</strong> Bạn có thể thanh toán trực tiếp qua cổng thanh toán điện tử VNPAY bằng cách sử dụng thẻ ngân hàng hoặc ví điện tử hỗ trợ VNPAY.</p>
    
                <p><strong>Quy trình thanh toán:</strong> Sau khi chọn phương thức VNPAY, bạn sẽ được chuyển đến trang thanh toán của VNPAY. Bạn chỉ cần chọn phương thức thanh toán phù hợp (thẻ ATM, thẻ tín dụng, hoặc ví điện tử) và xác nhận giao dịch.</p>
                
                <p><strong>Điều kiện áp dụng:</strong> Phương thức thanh toán qua VNPAY áp dụng cho tất cả đơn hàng và có thể có các ưu đãi giảm giá nếu bạn thanh toán qua cổng này.</p>
                
                <h5>Lưu ý:</h5>
                <ul>
                    <li><strong>Kiểm tra lại thông tin thanh toán:</strong> Trước khi xác nhận giao dịch, hãy kiểm tra lại tất cả thông tin thanh toán để đảm bảo không có sai sót trong quá trình giao dịch.</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
