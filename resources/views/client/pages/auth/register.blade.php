@extends('client.layouts.master')
@section('title')
Đăng ký
@endsection
@section('content')
@include('client.pages.components.breadcrumb', [
    'pageHeader' => 'Đăng ký',
    'parent' => [
        'route' => '',
        'name' => 'Trang chủ',
    ],
])
<section class="section-b-space login-bg-img pt-0">
    <div class="custom-container login-page container">
        <div class="row align-items-center">
            <div class="col-xxl-7 col-6 d-none d-lg-block">
                <div class="login-img">
                    <img class="img-fluid" src="/template/client/assets/images/login/1.svg" alt="">
                </div>
            </div>
            <div class="col-xxl-4 col-lg-6 mx-auto">
                <div class="log-in-box">
                    <div class="log-in-title">
                        <h4>Chào mừng đến với GunDam Win</h4>
                        <p>Tạo mới tài khoản</p>
                    </div>
                    <div class="login-box">
                        <form action="{{ route('auth.register-post') }}" class="row g-3" method="POST">
                            @csrf
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" name="full_name" id="floatingInputValue" type="text" placeholder="Full Name" value="{{ old('full_name') }}">
                                    <label for="floatingInputValue">Nhập tên đầy đủ của bạn</label>
                                </div>
                                @error('full_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" name="email" id="floatingInputValue1" type="email" placeholder="name@example.com" value="{{ old('email') }}">
                                    <label for="floatingInputValue1">Nhập địa chỉ email của bạn</label>
                                </div>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" name="phone" id="floatingInputValue1" type="tel" placeholder="Nhập số điện thoại của bạn" value="{{ old('phone') }}">
                                    <label for="floatingInputValue1">Nhập số điện thoại</label>
                                </div>
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" name="password" id="floatingInputValue2" type="password" placeholder="Password" value="{{ old('password') }}">
                                    <label for="floatingInputValue2">Nhập mật khẩu của bạn</label>
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" name="password_confirmation" id="password_confirmation" type="password" placeholder="Password Confirmation" value="{{ old('password_confirmation') }}">
                                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="forgot-box">
                                    <div>
                                        <input class="custom-checkbox me-2" id="category1" type="checkbox" name="agree_terms">
                                        <label for="category1">Tôi đồng ý với <span>Điều khoản </span>và <span>Quyền riêng tư</span></label>
                                        @error('agree_terms')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn login btn_black sm" type="submit">Đăng ký</button>
                            </div>
                        </form>
                    </div>
                    <div class="sign-up-box">
                        <p>Đã có tài khoản?</p>
                        <a href="{{ route('auth.login-view') }}">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
