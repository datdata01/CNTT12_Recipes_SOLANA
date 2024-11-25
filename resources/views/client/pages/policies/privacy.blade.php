@extends('client.layouts.master')
@section('title', 'Chính sách bảo mật')

@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Chính sách bảo mật',
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
                    <h2>Chính sách bảo mật</h2>
                </a>
                <p>GUNDAM WIN cam kết sẽ bảo mật những thông tin mang tính riêng tư của khách hàng. Quý khách vui lòng đọc
                    bản “Chính sách bảo mật” dưới đây để hiểu hơn những cam kết mà chúng tôi thực hiện, nhằm tôn trọng và
                    bảo vệ quyền lợi của người truy cập</p>
                <h5>1. THU THẬP THÔNG TIN CÁ NHÂN</h5>
                <p>Các thông tin thu thập thông qua website <a href="#">GUNDAM WIN</a> sẽ giúp chúng tôi:</p>
                <ul>
                    <li>- Hỗ trợ khách hàng khi mua sản phẩm</li><br>
                    <li>- Giải đáp thắc mắc khách hàng</li><br>
                    <li>- Cung cấp cho bạn thông tin mới nhất trên website của chúng tôi</li><br>
                    <li>- Xem xét và nâng cấp nội dung và giao diện của website</li><br>
                    <li>- Thực hiện các bảng khảo sát khách hàng</li><br>
                    <li>- Thực hiện các hoạt động quảng bá liên quan đến các sản phẩm và dịch vụ của GUNDAM WIN.</li>
                </ul>
                <p>Để truy cập và sử dụng một số dịch vụ tại <a href="#">GUNDAM WIN</a>, quý khách có thể sẽ được yêu
                    cầu đăng ký với chúng tôi thông tin cá nhân (Email, Họ tên, Số điện thoại liên lạc…).
                    Mọi thông tin khai báo phải đảm bảo tính chính xác và hợp pháp. GUNDAM WIN không chịu mọi trách nhiệm
                    liên quan đến pháp luật của thông tin khai báo.</p>
                <p>Chúng tôi cũng có thể thu thập thông tin về số lần ghé thăm, bao gồm số trang quý khách xem, số links
                    (liên kết) bạn click và những thông tin khác liên quan đến việc kết nối đến <a href="#">GUNDAM
                        WIN</a>. Chúng tôi cũng thu thập các thông tin mà trình duyệt Web (Browser) quý khách sử dụng mỗi
                    khi truy cập vào website <a href="#">GUNDAM WIN</a>, bao gồm: địa chỉ IP, loại Browser, ngôn ngữ sử
                    dụng, thời gian và những địa chỉ mà Browser truy xuất đến.</p>

                <h5>2. SỬ DỤNG THÔNG TIN CÁ NHÂN</h5>
                <p>GUNDAM WIN thu thập và sử dụng thông tin cá nhân quý khách với mục đích phù hợp và hoàn toàn tuân thủ nội
                    dung của “Chính sách bảo mật” này.</p>
                <p>Khi cần thiết, chúng tôi có thể sử dụng những thông tin này để liên hệ trực tiếp với bạn dưới các hình
                    thức như: gởi thư ngỏ, đơn đặt hàng, thư cảm ơn, thông tin về kỹ thuật và bảo mật, quý khách có thể nhận
                    được thư định kỳ cung cấp thông tin sản phẩm, dịch vụ mới, thông tin về các sự kiện sắp tới hoặc thông
                    tin tuyển dụng nếu quý khách đăng kí nhận email thông báo.</p>
                <h5>3. CHIA SẺ THÔNG TIN CÁ NHÂN</h5>
                <p>Ngoại trừ các trường hợp về Sử dụng thông tin cá nhân như đã nêu trong chính sách này, chúng tôi cam kết
                    sẽ không tiết lộ thông tin cá nhân bạn ra ngoài.</p>
                <p>Trong một số trường hợp, chúng tôi có thể thuê một đơn vị độc lập để tiến hành các dự án nghiên cứu thị
                    trường và khi đó thông tin của bạn sẽ được cung cấp cho đơn vị này để tiến hành dự án. Bên thứ ba này sẽ
                    bị ràng buộc bởi một thỏa thuận về bảo mật mà theo đó họ chỉ được phép sử dụng những thông tin được cung
                    cấp cho mục đích hoàn thành dự án.</p>
                <p>Chúng tôi có thể tiết lộ hoặc cung cấp thông tin cá nhân của bạn trong các trường hợp thật sự cần thiết
                    như sau: (a) khi có yêu cầu của các cơ quan pháp luật; (b) trong trường hợp mà chúng tôi tin rằng điều
                    đó sẽ giúp chúng tôi bảo vệ quyền lợi chính đáng của mình trước pháp luật; (c) tình huống khẩn cấp và
                    cần thiết để bảo vệ quyền an toàn cá nhân của các thành viên khác tại <a href="#">GUNDAM WIN</a>
                </p>
                <h5>4. TRUY XUẤT THÔNG TIN CÁ NHÂN</h5>
                <p>Bất cứ thời điểm nào quý khách cũng có thể truy cập và chỉnh sửa những thông tin cá nhân của mình theo
                    các liên kết thích hợp mà chúng tôi cung cấp.</p>

                <h5>5. BẢO MẬT THÔNG TIN CÁ NHÂN</h5>
                <p>Khi bạn gửi thông tin cá nhân của bạn cho chúng tôi, bạn đã đồng ý với các điều khoản mà chúng tôi đã nêu
                    ở trên, GUNDAM WIN cam kết bảo mật thông tin cá nhân của quý khách bằng mọi cách thức có thể. Chúng tôi
                    sẽ sử dụng nhiều công nghệ bảo mật thông tin khác nhau như: chuẩn quốc tế PCI, SSL,… nhằm bảo vệ thông
                    tin này không bị truy lục, sử dụng hoặc tiết lộ ngoài ý muốn.</p>
                <p>Tuy nhiên do hạn chế về mặt kỹ thuật, không một dữ liệu nào có thể được truyền trên đường truyền internet
                    mà có thể được bảo mật 100%. Do vậy, chúng tôi không thể đưa ra một cam kết chắc chắn rằng thông tin quý
                    khách cung cấp cho chúng tôi sẽ được bảo mật một cách tuyệt đối an toàn, và chúng tôi không thể chịu
                    trách nhiệm trong trường hợp có sự truy cập trái phép thông tin cá nhân của quý khách như các trường hợp
                    quý khách tự ý chia sẻ thông tin với người khác…. Nếu quý khách không đồng ý với các điều khoản như đã
                    mô tả ở trên, Chúng tôi khuyên quý khách không nên gửi thông tin đến cho chúng tôi.</p>
                <p>Vì vậy, <a href="#">GUNDAM WIN</a> cũng khuyến cáo quý khách nên bảo mật các thông tin liên quan đến
                    mật khẩu truy xuất của quý khách và không nên chia sẻ với bất kỳ người nào khác.</p>
                <p>Nếu sử dụng máy tính chung nhiều người, quý khách nên đăng xuất, hoặc thoát hết tất cả cửa sổ Website
                    đang mở.</p>

                <h5>6. THAY ĐỔI VỀ CHÍNH SÁCH</h5>
                <p>Chúng tôi hoàn toàn có thể thay đổi nội dung trong trang này mà không cần phải thông báo trước, để phù
                    hợp với các nhu cầu của GUNDAM WIN cũng như nhu cầu và sự phản hồi từ khách hàng nếu có. Khi cập nhật
                    nội dung chính sách này, chúng tôi sẽ chỉnh sửa lại thời gian “Cập nhật lần cuối” bên dưới.</p>
                <p>Nội dung “Chính sách bảo mật” này chỉ áp dụng tại GUNDAM WIN, không bao gồm hoặc liên quan đến các bên
                    thứ ba đặt quảng cáo hay có links tại GUNDAM WIN. Chúng tôi khuyến khích bạn đọc kỹ chính sách An toàn
                    và Bảo mật của các trang web của bên thứ ba trước khi cung cấp thông tin cá nhân cho các trang web đó.
                    Chúng tôi không chịu trách nhiệm dưới bất kỳ hình thức nào về nội dung và tính pháp lý của trang web
                    thuộc bên thứ ba.</p>
                <p>Vì vậy, bạn đã đồng ý rằng, khi bạn sử dụng website của chúng tôi sau khi chỉnh sửa nghĩa là bạn đã thừa
                    nhận, đồng ý tuân thủ cũng như tin tưởng vào sự chỉnh sửa này. Do đó, chúng tôi đề nghị bạn nên xem
                    trước nội dung trang này trước khi truy cập các nội dung khác trên website cũng như bạn nên đọc và tham
                    khảo kỹ nội dung “Chính sách bảo mật” của từng website mà bạn đang truy cập.</p>
                <h5>9. THÔNG TIN LIÊN HỆ</h5>
                <p>Chúng tôi luôn hoan nghênh các ý kiến đóng góp, liên hệ và phản hồi thông tin từ bạn về “Chính sách bảo
                    mật” này. Nếu bạn có những thắc mắc liên quan xin vui lòng liên hệ với chúng tôi.</p>
            </div>
        </div>
    </section>
@endsection
