@extends('client.layouts.master')
@section('title')
    Sản phẩm yêu thích
@endsection
@section('content')
    @include('client.pages.components.breadcrumb', [
        'pageHeader' => 'Sản phẩm yêu thích',
        'parent' => [
            'route' => '',
            'name' => 'Trang chủ',
        ],
    ])
    <section class="section-b-space pt-0">
        <div class="custom-container wishlist-box container">
            <div class="product-tab-content ratio1_3">
                <div class="row-cols-xl-4 row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                    @foreach ($favorites as $favorite)
                        <div class="col">
                            <div class="product-box-3 product-wishlist">
                                <div class="img-wrapper">
                                    <div class="label-block">
                                        <a class="label-2 wishlist-icon delete-button"
                                           title="Remove from Wishlist" tabindex="0"
                                           data-id="{{ $favorite->id }}">
                                            <i class="iconsax" data-icon="trash" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="product-image">
                                        <a class="pro-first" href="{{ route('product', $favorite->product->id) }}">
                                            <img class="bg-img" src="{{ asset('storage/' . $favorite->product->image) }}" alt="product">
                                        </a>
                                        @php
                                            $firstImage = $favorite->product->productImages->first();
                                        @endphp
                                        <a class="pro-sec" href="{{ route('product', $favorite->product->id) }}">
                                            <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}"
                                                alt="product" />
                                        </a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        @for ($i = 0; $i < 5; $i++)
                                            <li><i class="fa-solid fa-star{{ $i < $favorite->product->rating ? '' : '-half-stroke' }}"></i></li>
                                        @endfor
                                        <li>{{ $favorite->product->rating }}</li>
                                    </ul>
                                    <a href="{{ route('product', $favorite->product->id) }}">
                                        <h6>{{ $favorite->product->name }}</h6>
                                    </a>
                                    <p class="list-per">{{ $favorite->product->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.wishlist-icon', function (e) {
                var favoriteId = $(this).data('id');
                var row = $(this).closest('.col'); // Lấy phần tử chứa sản phẩm yêu thích

                $.ajax({
                    url: '{{ url("api/remove-favorite") }}', // Gọi đúng route API
                    method: 'DElETE',
                    data: {
                        userId: @php
                            echo Auth::id();
                        @endphp,
                        favorite_id: favoriteId
                    },
                    success: function (response) {
                        if (response.status === 'removed') {
                            row.fadeOut(); // Xóa sản phẩm khỏi danh sách yêu thích
                            document.querySelector('#love').innerText = response.love
                        }
                    },
                    error: function (xhr, status, error) {
                        alert('Có lỗi xảy ra!');
                    }
                });
            });
        });
    </script>
@endpush

