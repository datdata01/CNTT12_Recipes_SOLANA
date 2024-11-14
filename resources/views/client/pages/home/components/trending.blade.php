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
                                        <div class="label-block"><span class="lable-1">NEW</span><a
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
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star"></i></li>
                                            <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                            <li><i class="fa-regular fa-star"></i></li>
                                            <li>4.3</li>
                                        </ul>
                                        <a href="{{ route('product', $product->id) }}">
                                            <h6>{{ $product->name }}</h6>
                                        </a>
                                        <p>
                                            @if ($product->productVariants->count() === 1)
                                                {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}₫
                                            @else
                                                {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}₫-
                                                {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}₫
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
                                    <div class="label-block"><span class="lable-1">NEW</span><a
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
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul>
                                    <a href="{{ route('product', $product->id) }}">
                                        <h6>{{ $product->name }}</h6>
                                    </a>
                                    <p>
                                        @if ($product->productVariants->count() === 1)
                                            {{ number_format($product->productVariants->first()->price, 0, ',', '.') }}₫
                                        @else
                                            {{ number_format($product->productVariants->min('price'), 0, ',', '.') }}₫-
                                            {{ number_format($product->productVariants->max('price'), 0, ',', '.') }}₫
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
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product-box-3">
                                <div class="img-wrapper">
                                    <div class="label-block"><span class="lable-1">NEW</span><a
                                            class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i
                                                class="iconsax" data-icon="heart" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a>
                                    </div>
                                    <div class="product-image"><a class="pro-first" href="product.html">
                                            <img class="bg-img"
                                                src="/template/client/assets/images/product/product-3/4.jpg"
                                                alt="product" /></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img"
                                                src="/template/client/assets/images/product/product-3/16.jpg"
                                                alt="product" /></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" tabindex="0"><i class="iconsax"
                                                data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Add to card">
                                            </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i
                                                class="iconsax" data-icon="eye" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                                    </div>
                                    <div class="countdown">
                                        <ul class="clockdiv4">
                                            <li>
                                                <div class="timer">
                                                    <div class="days"></div>
                                                </div><span class="title">Days</span>
                                            </li>
                                            <li class="dot"> <span>:</span></li>
                                            <li>
                                                <div class="timer">
                                                    <div class="hours"></div>
                                                </div><span class="title">Hours</span>
                                            </li>
                                            <li class="dot"> <span>:</span></li>
                                            <li>
                                                <div class="timer">
                                                    <div class="minutes"></div>
                                                </div><span class="title">Min</span>
                                            </li>
                                            <li class="dot"> <span>:</span></li>
                                            <li>
                                                <div class="timer">
                                                    <div class="seconds"></div>
                                                </div><span class="title">Sec</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="product.html">
                                        <h6>Greciilooks Women's Stylish Top</h6>
                                    </a>
                                    <p>$100.00 <del>$140.00</del><span>-20%</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product-box-3">
                                <div class="img-wrapper">
                                    <div class="label-block"><span class="lable-1">NEW</span><a
                                            class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i
                                                class="iconsax" data-icon="heart" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a>
                                    </div>
                                    <div class="product-image"><a class="pro-first" href="product.html">
                                            <img class="bg-img"
                                                src="/template/client/assets/images/product/product-3/11.jpg"
                                                alt="product" /></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img"
                                                src="/template/client/assets/images/product/product-3/15.jpg"
                                                alt="product" /></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" tabindex="0"><i class="iconsax"
                                                data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Add to card">
                                            </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i
                                                class="iconsax" data-icon="eye" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="product.html">
                                        <h6>Wide Linen-Blend Trousers</h6>
                                    </a>
                                    <p>$100.00 <del>$18.00 </del></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product-box-3">
                                <div class="img-wrapper">
                                    <div class="label-block"><span class="lable-1">NEW</span><a
                                            class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i
                                                class="iconsax" data-icon="heart" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a>
                                    </div>
                                    <div class="product-image"><a class="pro-first" href="product.html">
                                            <img class="bg-img"
                                                src="/template/client/assets/images/product/product-3/9.jpg"
                                                alt="product" /></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img"
                                                src="/template/client/assets/images/product/product-3/14.jpg"
                                                alt="product" /></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" tabindex="0"><i class="iconsax"
                                                data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Add to card">
                                            </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i
                                                class="iconsax" data-icon="eye" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="product.html">
                                        <h6>Long Sleeve Rounded T-Shirt</h6>
                                    </a>
                                    <p>$12.30 <del>$140.00</del><span>-20%</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="product-box-3">
                                <div class="img-wrapper">
                                    <div class="label-block"><span class="lable-1">NEW</span><a
                                            class="label-2 wishlist-icon" href="javascript:void(0)" tabindex="0"><i
                                                class="iconsax" data-icon="heart" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Add to Wishlist"></i></a>
                                    </div>
                                    <div class="product-image"><a class="pro-first" href="product.html">
                                            <img class="bg-img"
                                                src="/template/client/assets/images/product/product-3/10.jpg"
                                                alt="product" /></a><a class="pro-sec" href="product.html"> <img
                                                class="bg-img"
                                                src="/template/client/assets/images/product/product-3/13.jpg"
                                                alt="product" /></a></div>
                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#addtocart" tabindex="0"><i class="iconsax"
                                                data-icon="basket-2" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Add to card">
                                            </i></a><a href="compare.html" tabindex="0"><i class="iconsax"
                                                data-icon="arrow-up-down" aria-hidden="true" data-bs-toggle="tooltip"
                                                data-bs-title="Compare"></i></a><a href="#"
                                            data-bs-toggle="modal" data-bs-target="#quick-view" tabindex="0"><i
                                                class="iconsax" data-icon="eye" aria-hidden="true"
                                                data-bs-toggle="tooltip" data-bs-title="Quick View"></i></a>
                                    </div>
                                    <div class="countdown">
                                        <ul class="clockdiv5">
                                            <li>
                                                <div class="timer">
                                                    <div class="days"></div>
                                                </div><span class="title">Days</span>
                                            </li>
                                            <li class="dot"> <span>:</span></li>
                                            <li>
                                                <div class="timer">
                                                    <div class="hours"></div>
                                                </div><span class="title">Hours</span>
                                            </li>
                                            <li class="dot"> <span>:</span></li>
                                            <li>
                                                <div class="timer">
                                                    <div class="minutes"></div>
                                                </div><span class="title">Min</span>
                                            </li>
                                            <li class="dot"> <span>:</span></li>
                                            <li>
                                                <div class="timer">
                                                    <div class="seconds"></div>
                                                </div><span class="title">Sec</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product-detail">
                                    <ul class="rating">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                        <li>4.3</li>
                                    </ul><a href="product.html">
                                        <h6>Blue lined White T-Shirt</h6>
                                    </a>
                                    <p>$190.00 <del>$210.00</del></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
