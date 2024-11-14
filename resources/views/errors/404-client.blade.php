@extends('client.layouts.master')
@section('title')
    404
@endsection
@section('content')
    <section class="section-b-space pt-0">
        <div class="custom-container error-img container">
            <div class="row g-4">
                <div class="col-12 px-0"> <a href="#"><img class="img-fluid"
                            src="/template/client/assets/images/other-img/404.png" alt=""></a></div>
                <div class="col-12">
                    <h2>Trang không tồn tại </h2>
                    <p>Trang bạn đang tìm kiếm không tồn tại hoặc đã xảy ra lỗi khác. Quay lại hoặc chuyển đến
                        chọn hướng mới. </p><a class="btn btn_black rounded" href="{{ route('home') }}">Quay về trang chủ
                        <svg>
                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                        </svg></a>
                </div>
            </div>
        </div>
    </section>
@endsection
