@extends('client.layouts.master')
@section('title', 'Chính sách vận chuyển')

@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Chính sách vận chuyển',
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
                    <h2>Chính sách vận chuyển</h2>
                </a>
                <p>Với phương châm luôn đảm bảo những quyền lợi tốt nhất cho khách hàng, GUNDAM WIN cung cấp dịch vụ vận
                    chuyển sản phẩm tận tay, mang lại sự tiện ích và đáp ứng nhu cầu mua sắm của mọi khách hàng trên khắp
                    toàn quốc, thoải mái lựa chọn sản phẩm thông qua website hay mua trực tiếp tại GUNDAM WIN.</p>
                <br>
                
                <p>🎉 Gundam Win cam kết mang đến trải nghiệm mua sắm dễ dàng và tiện lợi nhất. Để hỗ trợ khách hàng trên mọi miền đất nước, chúng tôi triển khai chính sách giao hàng miễn phí toàn quốc.</p>
                <h6>THỜI GIAN GIAO HÀNG</h6>
                <ul>
                    <li>- Đối với khu vực nội thành: Sản phẩm sẽ được chuyển đến tận tay khách hàng trong vòng 24h, tính từ
                        lúc xác nhận đơn hàng.</li><br>
                    <li>- Đối với khu vực tỉnh/ thành phố khác: Khách hàng sẽ nhận được sản phẩm trong khoảng thời gian từ 24
                        – 72 tiếng; trong đó, những khách thuộc vùng sâu, vùng xa hay các địa điểm khó tìm có thể nhận sau 3
                        đến 5 ngày.</li>
                </ul>
                <h6>QUYỀN LỢI KHÁCH HÀNG</h6>
                <ul >
                    <li style="list-style-type: circle;">- Đảm bảo giao hàng đúng thời hạn đã cam kết.</li> <br>
                    <li>- Hàng sẽ được gửi đến đúng địa chỉ mà khách hàng đã đăng kí trong đơn hàng khi thanh toán.</li><br>
                    <li>- Khách hàng sẽ được kiểm tra sản phẩm thuộc đơn hàng của mình trước khi thanh toán cho bên vận
                        chuyển.</li>
                </ul>

            </div>
    </section>
@endsection
