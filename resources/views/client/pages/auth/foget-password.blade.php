@extends('client.layouts.master')
@section('title')
    Quên mật khẩu
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Quên mật khẩu',
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
                            <h4>Chào mừng đến với Katie</h4>
                            <p>Quên mật khẩu?</p>
                        </div>
                        <div class="login-box">
                            <form class="row g-3" method="POST" >
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" name="email" value="{{ old('email') }}" id="floatingInputValue" type="text" placeholder="Nhập email của bạn">
                                        <label for="floatingInputValue">Nhập email</label>
                                    </div>
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button class="btn login btn_black sm" type="submit">Gửi yêu cầu</button>
                                </div>
                            </form>
                        </div>
                        <div class="sign-up-box">
                            <a class="text-decoration-underline" href="{{ route('auth.login-view') }}">Trở về Đăng nhập</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('input', function () {
            if (this.name === 'email') {
                // Loại bỏ tất cả khoảng trắng vì email không hợp lệ khi có khoảng trắng
                this.value = this.value.replace(/\s/g, '');
            }
        });
    });
});
</script>
@endpush
@endsection
