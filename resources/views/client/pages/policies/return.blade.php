@extends('client.layouts.master')
@section('title', 'Chính sách hoàn hàng')

@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Chính sách hoàn hàng',
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
            list-style-type: disc;
        }

        ul li {
            margin-bottom: 10px;
            
        }

        p {
            margin-bottom: 15px;
        }

        h6 {
            color: #333f48;
            font-weight: bold;
            line-height: normal;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";

        }
    </style>
    <section class="section-b-space pt-0">
        <div class="container">
            <div class="contact-main">
                <a href="#">
                    <h2>Chính sách hoàn hàng</h2>
                </a>
                <p><strong>Gundam Win</strong> luôn mong muốn mang đến cho khách hàng trải nghiệm mua sắm tuyệt vời nhất. Dưới đây là các điều khoản và điều kiện trong chính sách đổi trả:</p>

                <h5>1. Điều kiện hoàn hàng</h5>
                <ul>
                    <li>- Sản phẩm bị lỗi kỹ thuật từ nhà sản xuất (nứt, gãy, thiếu linh kiện, lỗi sơn...).</li> <br>
                    <li>- Sản phẩm giao không đúng với đơn hàng đã đặt (sai mẫu, sai kích thước, sai màu sắc).</li>
                    <li>- Sản phẩm bị hư hại trong quá trình vận chuyển (cần chụp hình ngay khi nhận hàng để làm bằng chứng).</li>
                   
                </ul>
            
                <h5>2. Thời gian áp dụng</h5>
                <p>Yêu cầu đổi/trả phải được gửi trong vòng <strong>7 ngày kể từ ngày nhận hàng</strong>. Sau thời gian này, chúng tôi xin phép từ chối hỗ trợ hoàn hàng.</p>
            
                <h5>3. Quy trình hoàn hàng</h5>
                <ol>
                    <li>
                        <strong>Liên hệ với Gundam Win:</strong>
                        <p>Gửi yêu cầu qua hotline hoặc email, cung cấp thông tin đơn hàng và hình ảnh sản phẩm lỗi.</p>
                    </li>
                    <li>
                        <strong>Kiểm tra sản phẩm:</strong>
                        <p>Đội ngũ chăm sóc khách hàng sẽ xác nhận tình trạng sản phẩm và thông báo kết quả trong vòng <strong>2 ngày làm việc</strong>.</p>
                    </li>
                    <li>
                        <strong>Hoàn tiền sản phẩm:</strong>
                        <p>Người bán sẽ liên hệ bạn để hoàn trả lại tiền khi đơn hoàn được thanh toán bằng phương thức MOMO và VNPAY.</p>
                        
                    </li>
                </ol>
            
                <h5>4. Phí hoàn hàng</h5>
                <ul>
                    <li><strong>Miễn phí hoàn hàng</strong> nếu lỗi xuất phát từ nhà sản xuất hoặc vận chuyển.</li> <br>
                   
                </ul>
            
                <h5>5. Lưu ý quan trọng</h5>
                <ul>
                    <li>Không áp dụng hoàn hàng với sản phẩm đã qua sử dụng, bị hư hỏng do lỗi từ phía khách hàng (rơi vỡ, lắp ráp sai cách,...).</li>
                    <li>Các sản phẩm trong chương trình khuyến mãi đặc biệt có thể không áp dụng chính sách này (xem chi tiết trên từng chương trình).</li>
                </ul>
            
                <p>**Gundam Win** cam kết xử lý hoàn hàng minh bạch và nhanh chóng, mang lại sự hài lòng cao nhất cho khách hàng! 🚀</p>
                <p>Liên hệ ngay <strong>Hotline: 0325-224-873</strong> hoặc email <strong>support@gundamwin.vn</strong> để được hỗ trợ chi tiết.</p>

            </div>
    </section>
@endsection
