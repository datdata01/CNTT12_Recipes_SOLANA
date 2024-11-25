@extends('client.layouts.master')
@section('title')
    Trang chủ
@endsection
@section('content')
    <!-- Banner -->
    <section class="home-section-3 pt-0">
        @include('client.pages.home.components.banner')
    </section>

    <!-- Service -->
    <section class="section-t-space">
        @include('client.pages.home.components.service')
    </section>
    <!-- Sale info -->
    <section class="section-t-space">
        @include('client.pages.home.components.sale-info')
    </section>
    <!--san pham trending-->
    <section class="section-t-space">
        @include('client.pages.home.components.trending')
    </section>
    <!--Banner 2-->
    {{-- <section class="section-t-space">
        @include('client.pages.home.components.banner-2')
    </section> --}}
    <!--san pham brand-->
    <section class="section-t-space">
        @include('client.pages.home.components.brand')
    </section>
    <!--top brand-->
    <section class="section-t-space">
        @include('client.pages.home.components.top-brand')
    </section>

    <!--contact-->
    <section class="section-t-space ratio3_3">
        @include('client.pages.home.components.contact')
    </section>
    <!--follow us-->
    <section class="section-b-space">
        @include('client.pages.home.components.follow-us')
    </section>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
        $(document).on('click', '.wishlist-icon', function(e) {
                e.preventDefault();
                var productId = $(this).data('id');
                var icon = $(this).find('i');
                @auth
                $.ajax({
                    url: '{{ route('toggle.favorite') }}',
                    method: 'POST',
                    data: {
                        userId: {{ Auth::id() }},
                        product_id: productId
                    },
                    success: function(response) {
                        console.log("Love status:", response);
                        $('#love').text(response.love);

                        // Cập nhật trạng thái hiển thị icon và văn bản
                        if (response.status === 'added') {
                            icon.eq(0).hide(); // Ẩn trái tim chưa yêu thích
                            icon.eq(1).show(); // Hiển thị trái tim đã yêu thích
                        } else {
                            icon.eq(1).hide(); // Ẩn trái tim đã yêu thích
                            icon.eq(0).show(); // Hiển thị trái tim chưa yêu thích
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire("Có lỗi xảy ra!", "", "error");
                        console.error(error);
                    }
                });
            @endauth

            @guest Swal.fire({
                title: "Bạn cần đăng nhập để thực hiện thao tác này!",
                icon: "warning",
                confirmButtonText: "Đăng nhập",
                showCancelButton: true,
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('auth.login-view') }}";
                }
            });
        @endguest
        });
        });
    </script>
@endpush
