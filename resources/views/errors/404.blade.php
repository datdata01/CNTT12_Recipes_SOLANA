@extends('admin.layouts.master')
@section('title')
    404
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <h2 class="d-flex justify-content-center align-items-center mb-4 gap-2">
                        <span class="display-1 fw-bold">404</span>
                        <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
                    </h2>
                    <h3 class="h2 mb-2">Ối! Lỗi rồi.</h3>
                    <p class="mb-5">Trang không tồn tại.</p>
                    <a class="btn bsb-btn-5xl btn-dark rounded-pill fs-6 m-0 px-5" href="{{ route('home') }}"
                        role="button">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
@endsection
