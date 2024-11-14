@extends('client.layouts.master')
@section('title')
    Đăng nhập
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Đăng nhập',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ]);
    <section class="section-b-space login-bg-img pt-0">
        <div class="custom-container login-page container">
            <div class="row align-items-center">
                <div class="col-xxl-7 col-6 d-none d-lg-block">
                    <div class="login-img"> <img class="img-fluid" src="/template/client/assets/images/login/1.svg"
                            alt=""></div>
                </div>
                <div class="col-xxl-4 col-lg-6 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                        <h4>Chào mừng đến với GunDam Win</h4>
                        <p>Đăng nhập tài khoản</p>
                        </div>
                        <div class="login-box">
                            <form class="row g-3" action="{{route('auth.login-post')}}" method="POST">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating"><input class="form-control"name="email" value="{{ old('email', Cookie::get('email')) }}" id="floatingInputValue"
                                            type="email" placeholder="Nhập email của bạn"><label
                                            for="floatingInputValue">Nhập email</label></div>
                                            @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="col-12">
                                    <div class="form-floating"><input class="form-control" name="password" value="{{old('password', Cookie::get('password')) }}" id="floatingInputValue1"
                                            type="password" placeholder="Mật khẩu"><label
                                            for="floatingInputValue1">Nhập mật khẩu</label></div>
                                            @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                                <div class="col-12">
                                    <div class="forgot-box">
                                        <div>
                                        <input type="checkbox" class="custom-checkbox me-2" id="remember-me" name="remember" value="1">
                                        <label for="remember-me">Nhớ mật khẩu</label>
                                        </div>
                                        <a href="{{ route('auth.foget-password-view') }}">Quên mật khẩu?</a>
                                    </div>
                                </div>
                                <div class="col-12"> <button class="btn login btn_black sm" type="submit"
                                        data-bs-dismiss="modal" aria-label="Close">Đăng nhập</button></div>
                            </form>
                        </div>
                        <div class="other-log-in"></div>
                        <div class="sign-up-box">
                            <p>Bạn không có tài khoản?</p><a href="{{ route('auth.register-view') }}">Đăng ký</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
