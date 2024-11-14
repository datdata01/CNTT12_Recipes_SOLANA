@extends('client.pages.profile.layouts.master')
@section('title')
    Thông tin người dùng
@endsection
@section('profile')
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
            <div class="dashboard-right-box">
                <div class="my-dashboard-tab">
                    <div class="dashboard-items"> </div>
                    <div class="sidebar-title">
                        <div class="loader-line"></div>
                        <h4>Thông tin người dùng</h4>
                    </div>
                    <div class="dashboard-user-name">
                        <h6>Xin chào, <b>{{ Auth::user()->full_name }}</b></h6>
                        <p>Trang tổng quan của tôi cung cấp cho bạn một cái nhìn toàn diện về các số liệu và dữ liệu chính
                            liên quan đến hoạt động của bạn. Nó cung cấp thông tin chi tiết theo thời gian thực về hiệu
                            suất, bao gồm số liệu bán hàng, lưu lượng truy cập trang web, mức độ tương tác của khách hàng,
                            v.v. Với các tiện ích có thể tùy chỉnh và hình ảnh trực quan, nó tạo điều kiện cho việc ra quyết
                            định nhanh chóng và giúp bạn theo dõi tiến trình hướng tới mục tiêu của mình một cách hiệu quả.
                        </p>
                    </div>
                    <div class="total-box">
                        <div class="row gy-4">
                            <div class="col-xl-4">
                                <div class="totle-contain">
                                    <div class="wallet-point"><img src="/template/client/assets/images/svg-icon/wallet.svg"
                                            alt=""><img class="img-1"
                                            src="/template/client/assets/images/svg-icon/wallet.svg" alt=""></div>
                                    <div class="totle-detail">
                                        <h6>Balance</h6>
                                        <h4>$ 84.40 </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="totle-contain">
                                    <div class="wallet-point"><img src="/template/client/assets/images/svg-icon/coin.svg"
                                            alt=""><img class="img-1"
                                            src="/template/client/assets/images/svg-icon/coin.svg" alt=""></div>
                                    <div class="totle-detail">
                                        <h6>Total Points</h6>
                                        <h4>500</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="totle-contain">
                                    <div class="wallet-point"><img src="/template/client/assets/images/svg-icon/order.svg"
                                            alt=""><img class="img-1"
                                            src="/template/client/assets/images/svg-icon/order.svg" alt=""></div>
                                    <div class="totle-detail">
                                        <h6>Total Orders</h6>
                                        <h4>12</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-about">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5>Thông tin hồ sơ</h5>
                                </div>
                                <ul class="profile-information">
                                    <li>
                                        <h6>Họ và tên :</h6>
                                        <p>{{ Auth::user()->full_name }}</p>
                                    </li>
                                    <li>
                                        <h6>Số điện thoại:</h6>
                                        <p>{{ Auth::user()->phone }}</p>
                                    </li>
                                    {{-- <li>
                                        <h6>Address:</h6>
                                        <p>26, Starts Hollow Colony Denver, Colorado, United States
                                            80014</p>
                                    </li> --}}
                                </ul>
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5>Chi tiết đăng nhập</h5>
                                </div>
                                <ul class="profile-information mb-0">
                                    <li>
                                        <h6>Email :</h6>
                                        <p>{{ Auth::user()->email }}</p>
                                    </li>
                                    <li>
                                        <h6>Mật khẩu :</h6>
                                        <p>●●●●●●<span data-bs-toggle="modal" data-bs-target="#edit-password"
                                                title="Quick View" tabindex="0">Thay đổi</span></p>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-5">
                                <div class="profile-image d-none d-xl-block"> <img class="img-fluid"
                                        src="/template/client/assets/images/other-img/dashboard.png" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('client.pages.profile.layouts.components.edit-password')
@endsection
