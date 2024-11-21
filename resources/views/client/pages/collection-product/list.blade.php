<div class="product-tab-content ratio1_3">
    <div class="row-cols-lg-4 row-cols-md-3 row-cols-2 grid-section view-option row g-3 g-xl-4" id="product-list">
        @foreach ($products as $product)
            <div>
                <div class="product-box-3">
                    <div class="img-wrapper">
                        <div class="label-block">
                            <a class="label-2 wishlist-icon" data-id="{{ $product->id }}" tabindex="0">
                                <i class="fa-regular fa-heart"
                                    style="{{ $product->favorites->isNotEmpty() ? 'display: none;' : '' }}"></i>
                                <i class="fa-solid fa-heart"
                                    style="color: red; {{ $product->favorites->isNotEmpty() ? '' : 'display: none;' }}"></i>
                            </a>
                        </div>
                        <div class="product-image ratio_apos">
                            <a class="pro-first" href="{{ route('product', $product->id) }}">
                                <img class="bg-img" src="{{ '/storage/' . $product->image }}" alt="product"
                                    style="width: 100%; height: 300px; object-fit: cover;" />
                            </a>
                            @php
                                $firstImage = $product->productImages->first();
                            @endphp
                            <a class="pro-sec" href="{{ route('product', $product->id) }}">
                                <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}" alt="product"
                                    style="width: 100%; height: 300px; object-fit: cover;" />
                            </a>
                        </div>
                    </div>
                    <div class="product-detail">
                        <ul class="rating">
                            @php
                                $rating = $product->average_rating ? $product->average_rating : 0; // Lấy rating từ feedback
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <li>
                                    <i class="fa-solid fa-star"
                                        style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"></i>
                                </li>
                            @endfor
                        </ul>
                        <a href="{{ route('product', $product->id) }}">
                            <h6>{{ $product->name }}</h6>
                        </a>
                        <p>
                            @if ($product->productVariants->count() === 1)
                                {{ number_format($product->productVariants->first()->price, 0, ',', '.') }} VND
                            @else
                                {{ number_format($product->productVariants->min('price'), 0, ',', '.') }} -
                                {{ number_format($product->productVariants->max('price'), 0, ',', '.') }} VND
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

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
