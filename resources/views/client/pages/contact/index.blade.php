@extends('client.layouts.master')
@section('title')
    Liên hệ
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Liên hệ',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ]);
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="contact-main">
                <div class="row gy-3">
                    <div class="col-12">
                        <div class="title-1 address-content">
                            <p class="pb-0">Hãy liên hệ<span></span></p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="address-items">
                            <div class="icon-box"> <i class="iconsax" data-icon="phone-calling"></i></div>
                            <div class="contact-box">
                                <h6>Số liên lạc</h6>
                                <p>+91 123 - 456 - 7890</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="address-items">
                            <div class="icon-box"> <i class="iconsax" data-icon="mail"></i></div>
                            <div class="contact-box">
                                <h6>Địa chỉ email</h6>
                                <p>katie098@gmail.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="address-items">
                            <div class="icon-box"> <i class="iconsax" data-icon="map-1"></i></div>
                            <div class="contact-box">
                                <h6>Địa chỉ khác</h6>
                                <p>14 P.Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="address-items">
                            <div class="icon-box"> <i class="iconsax" data-icon="location"></i></div>
                            <div class="contact-box">
                                <h6>Văn phòng làm việc</h6>
                                <p>Tòa P Cao đẳng FPT Polytechnic</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="contact-main">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 order-lg-1 order-2">
                        <div class="contact-box">
                            <h4>Liên hệ với chúng tôi</h4>
                            <p>Nếu bạn có những sản phẩm tuyệt vời hoặc muốn hợp tác, hãy liên hệ với chúng tôi.</p>
                            <div class="contact-form">
                                <div class="row gy-4">
                                    <div class="col-12"> <label class="form-label" for="inputEmail4">Họ và tên
                                        </label><input class="form-control" id="inputEmail4" type="text" name="text"
                                            placeholder="Nhập họ và tên"></div>
                                    <div class="col-6"><label class="form-label" for="inputEmail5">Địa chỉ email
                                        </label><input class="form-control" id="inputEmail5" type="email" name="email"
                                            placeholder="Nhập địa chỉ email"></div>
                                    <div class="col-6"><label class="form-label" for="inputEmail6">Số điện thoại
                                        </label><input class="form-control" id="inputEmail6" type="number" name="number"
                                            placeholder="Nhập số điện thoại"></div>
                                    <div class="col-12"> <label class="form-label">Tin nhắn</label>
                                        <textarea class="form-control" id="message" rows="6" placeholder="Nhập tin nhắn"></textarea>
                                    </div>
                                    <div class="col-12"> <button class="btn btn_black sm rounded" type="submit"> Gửi tin
                                            nhắn </button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 order-lg-2 offset-xl-1 order-1">
                        <div class="contact-img"> <img class="img-fluid" src="/template/client/assets/images/contact/1.svg"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
