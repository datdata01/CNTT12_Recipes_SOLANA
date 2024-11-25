<div class="custom-container flash-box container">
    <div class="row gy-3">
        <div class="col-12">
            <div class="d-sm-flex d-block justify-content-between align-items-center">
                <div class="title-1">
                    <p>Bộ sưu tập thương hiệu<span></span></p>
                    <h3>sản phẩm yêu thích</h3>
                </div>
                <div class="link-hover-anim underline"><a class="btn btn_underline link-strong link-strong-unhovered"
                        href="{{ route('collection-product') }}">Xem tất cả sản phẩm<svg>
                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                        </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                        href="{{ route('collection-product') }}">Xem tất cả sản phẩm<svg>
                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                        </svg></a></div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-6 col-12 order-xxl-1 order-2">
            <div class="row gy-4">
                @foreach ($products->take(2) as $product)
                    <div class="col-xxl-12 col-md-6 col-12">
                        <div class="flash-content">
                            <a class="pro-first" href="{{ route('product', $product->id) }}">
                                <img class="img-fluid" src="{{ '/storage/' . $product->image }}" alt="product"
                                    style="width: 150px; height: 190px; object-fit: cover;" />
                            </a>
                            <div>
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
                            <div class="flash-lable"> <span>-30%</span></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-xxl-6 col-lg-6 col-12 order-xxl-2 order-1">
            <div class="flash-images ratio50_2">
                @if ($rightBanners)
                <a href="{{$rightBanners->link}}"><img class="bg-img"
                    src="{{ asset('storage/' . $rightBanners->image_url) }}" alt="" /></a>
               
                
                <div class="banner-2">
                    <h3>{{$rightBanners->title}}</h3>
                   
                    <div class="countdown">
                        <ul class="clockdiv8">
                            <li>
                                <div class="timer">
                                    <div class="days"></div>
                                </div><span class="title">Ngày</span>
                            </li>
                            <li class="dot"> <span> </span><span></span></li>
                            <li>
                                <div class="timer">
                                    <div class="hours"></div>
                                </div><span class="title">Giờ</span>
                            </li>
                            <li class="dot"> <span> </span><span></span></li>
                            <li>
                                <div class="timer">
                                    <div class="minutes"></div>
                                </div><span class="title">Phút</span>
                            </li>
                            <li class="dot"> <span> </span><span></span></li>
                            <li>
                                <div class="timer">
                                    <div class="seconds"></div>
                                </div><span class="title">Giây</span>
                            </li>
                        </ul>
                    </div>
                    <div class="link-hover-anim underline"><a
                            class="btn btn_underline link-strong link-strong-unhovered"
                            href="collection-left-sidebar.html">Xem thêm<svg>
                                <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                            href="collection-left-sidebar.html">Xem thêm<svg>
                                <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a></div>
                </div>
                @else
                <a href="collection-left-sidebar.html"><img class="bg-img"
                    src="/template/client/assets/images/banner/banner-10.jpg" alt="" /></a>
            @endif
            </div>
        </div>
        <div class="col-xxl-3 col-12 order-xxl-3 order-3">
            <div class="row gy-4">
                @foreach ($products->slice(2, 2) as $product)
                    <div class="col-xxl-12 col-md-6 col-12">
                        <div class="flash-content">
                            <a class="pro-first" href="{{ route('product', $product->id) }}">
                                <img class="img-fluid" src="{{ '/storage/' . $product->image }}" alt="product"
                                    style="width: 150px; height: 190px; object-fit: cover;" />
                            </a>
                            <div>
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
                            <div class="flash-lable"> <span>-30%</span></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
