<style>
    .view-more {
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .logo-block:hover .view-more {
        opacity: 1;
        transform: translateY(0);
    }

    .logo-block img {
        transition: transform 0.3s ease;
    }

    .logo-block:hover img {
        transform: scale(1.05);
    }
</style>
<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-sm-3 col-6">
            <div class="brand-logo-txt">
                <div>
                    <h3>Danh mục sản phẩm</h3>
                    {{-- <h4>Giảm giá tới 40%</h4> --}}
                    <div class="link-hover-anim underline"><a class="btn btn_underline link-strong link-strong-unhovered"
                            href="{{ route('collection-product') }}">Mua sắm ngay<svg>
                                <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                            href="{{ route('collection-product') }}">Mua
                            sắm ngay<svg>
                                <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a></div>
                </div>
            </div>
        </div>
        @php
            $duplicatedCategories = $categoryProduct->concat($categoryProduct);
        @endphp

        <div class="col-sm-9 col-6 p-0">
            <div class="swiper slide-2">
                <div class="swiper-wrapper">
                    @foreach ($duplicatedCategories as $category)
                        <div class="swiper-slide logo-block position-relative">
                            <a href="{{ route('collection-product', $category->id) }}" class="d-block">
                                <!-- Hình ảnh -->
                                <img style="width: 180px; height: 180px; object-fit: cover;"
                                    src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                                <!-- Chữ tên danh mục -->
                                <span class="view-more d-block text-center fw-bold text-dark mt-2">
                                    {{ $category->name }}
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </div>
</div>
