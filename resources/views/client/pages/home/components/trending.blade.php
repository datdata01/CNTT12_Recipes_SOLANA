<div class="custom-container container">
    <div class="row special-products align-items-center">
        <div class="col-md-4 col-12">
            <div class="title-1">
                <p>Bộ sưu tập Gundam<span></span></p>
                <h3>Sản phẩm đặc biệt</h3>
            </div>
        </div>
        <div class="col-md-8 col-12">
            <div class="theme-tab-3">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation"><a class="nav-link active" data-bs-toggle="tab"
                            data-bs-target="#new-product" role="tab" aria-controls="new-product"
                            aria-selected="true">
                            <h6>Sản phẩm mới</h6>
                        </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab"
                            data-bs-target="#best-seller" role="tab" aria-controls="best-seller"
                            aria-selected="false">
                            <h6>Bán chạy nhất</h6>
                        </a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" data-bs-toggle="tab"
                            data-bs-target="#featured-product" role="tab" aria-controls="featured-product"
                            aria-selected="false">
                            <h6>Sản phẩm được đánh giá cao</h6>
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="col-12">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="new-product" role="tabpanel" tabindex="0">
                    <div class="row ratio1_3 gy-4 gx-3 gx-sm-4">
                        @foreach ($newProducts as $product)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="product-box-3">
                                    <div class="img-wrapper">
                                        <div class="label-block"><span class="lable-1">Mới</span><a
                                                class="label-2 wishlist-icon" href="javascript:void(0)"
                                                tabindex="0"><i class="iconsax" data-icon="heart" aria-hidden="true"
                                                    data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a>
                                        </div>
                                        <div class="label-block">
                                            <a class="label-2 wishlist-icon" data-id="{{ $product->id }}"
                                                tabindex="0">
                                                <i class="fa-regular fa-heart"
                                                    style="{{ $product->favorites->isNotEmpty() ? 'display: none;' : '' }}"></i>
                                                <i class="fa-solid fa-heart"
                                                    style="color: red; {{ $product->favorites->isNotEmpty() ? '' : 'display: none;' }}"></i>
                                            </a>
                                        </div>
                                        <div class="product-image ratio_apos">
                                            <a class="pro-first" href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ '/storage/' . $product->image }}"
                                                    alt="product"
                                                    style="width: 100%; height: 300px; object-fit: cover;" />
                                            </a>
                                            @php
                                                $firstImage = $product->productImages->first();
                                            @endphp
                                            <a class="pro-sec" href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}"
                                                    alt="product"
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
                                                {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}
                                                VND
                                            @else
                                                {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}
                                                -
                                                {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}
                                                VND
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="best-seller" role="tabpanel" tabindex="0">
                    <div class="row ratio1_3 gy-4">
                        @foreach ($bestSellingProducts as $product)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="product-box-3">
                                    <div class="img-wrapper">
                                        <div class="label-block"><span class="lable-1">Bán chạy</span><a
                                                class="label-2 wishlist-icon" href="javascript:void(0)"
                                                tabindex="0"><i class="iconsax" data-icon="heart" aria-hidden="true"
                                                    data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a>
                                        </div>
                                        <div class="label-block">
                                            <a class="label-2 wishlist-icon" data-id="{{ $product->id }}"
                                                tabindex="0">
                                                <i class="fa-regular fa-heart"
                                                    style="{{ $product->favorites->isNotEmpty() ? 'display: none;' : '' }}"></i>
                                                <i class="fa-solid fa-heart"
                                                    style="color: red; {{ $product->favorites->isNotEmpty() ? '' : 'display: none;' }}"></i>
                                            </a>
                                        </div>
                                        <div class="product-image ratio_apos">
                                            <a class="pro-first" href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ '/storage/' . $product->image }}"
                                                    alt="product"
                                                    style="width: 100%; height: 300px; object-fit: cover;" />
                                            </a>
                                            @php
                                                $firstImage = $product->productImages->first();
                                            @endphp
                                            <a class="pro-sec" href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}"
                                                    alt="product"
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
                                                {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}
                                                VND
                                            @else
                                                {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}
                                                -
                                                {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}
                                                VND
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="featured-product" role="tabpanel" tabindex="0">
                    <div class="row ratio1_3 gy-4">
                        @foreach ($averageRatings as $product)
                            {{-- @dd($product->average_rating) --}}
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="product-box-3">
                                    <div class="img-wrapper">
                                        <div class="label-block"><span class="lable-1">Đánh giá cao</span><a
                                                class="label-2 wishlist-icon" href="javascript:void(0)"
                                                tabindex="0"><i class="iconsax" data-icon="heart"
                                                    aria-hidden="true" data-bs-toggle="tooltip"
                                                    data-bs-title="Add to Wishlist"></i></a>
                                        </div>
                                        <div class="label-block">
                                            <a class="label-2 wishlist-icon" data-id="{{ $product->id }}"
                                                tabindex="0">
                                                <i class="fa-regular fa-heart"
                                                    style="{{ $product->favorites->isNotEmpty() ? 'display: none;' : '' }}"></i>
                                                <i class="fa-solid fa-heart"
                                                    style="color: red; {{ $product->favorites->isNotEmpty() ? '' : 'display: none;' }}"></i>
                                            </a>
                                        </div>
                                        <div class="product-image ratio_apos">
                                            <a class="pro-first" href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ '/storage/' . $product->image }}"
                                                    alt="product"
                                                    style="width: 100%; height: 300px; object-fit: cover;" />
                                            </a>
                                            @php
                                                $firstImage = $product->productImages->first();
                                            @endphp
                                            <a class="pro-sec" href="{{ route('product', $product->id) }}">
                                                <img class="bg-img" src="{{ '/storage/' . $firstImage->image_url }}"
                                                    alt="product"
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
                                                {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}
                                                VND
                                            @else
                                                {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}
                                                -
                                                {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}
                                                VND
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
