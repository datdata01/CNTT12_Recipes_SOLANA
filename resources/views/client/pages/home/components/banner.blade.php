<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-2 d-none d-xl-block">
            <ul class="nav-submenu">
                @isset($categoryProduct)
                    @foreach ($categoryProduct as $cate)
                        <li>
                            <a href="{{ route('collection-product', $cate->id) }}">
                                {{ $cate->name }}
                            </a>
                        </li>
                    @endforeach
                @else
                    <li>Không có danh mục nào</li>
                @endisset
            </ul>
        </div>
        <div class="col pe-0">
            @if ($headerBanners)
                <div class="home-banner p-right"> <img class="img-fluid"
                        src="{{ asset('storage/' . $headerBanners->image_url) }}" alt="{{ $headerBanners->title }}" />
                    <div class="contain-banner">
                        <div>

                            <h1>{{ $headerBanners->title }}</h1>

                            <div class="link-hover-anim underline"><a
                                    class="btn btn_underline link-strong link-strong-unhovered"
                                    href="{{ $headerBanners->link }}">Xem ngay<svg>
                                        <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                                    </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                                    href="{{ $headerBanners->link }}">Xem ngay<svg>
                                        <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                                    </svg></a></div>
                        </div>
                    </div>
                </div>
            @else
                <div class="home-banner p-right"> <img class="img-fluid"
                        src="/template/client/assets/images/layout-3/1.jpg" alt="" />
                    <div class="contain-banner">
                        <div>

                            <h1>Tiêu đề hiện không có</h1>

                            <div class="link-hover-anim underline"><a
                                    class="btn btn_underline link-strong link-strong-unhovered" href="#">Xem
                                    ngay<svg>
                                        <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                                    </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                                    href="#">Xem ngay<svg>
                                        <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                                    </svg></a></div>
                        </div>
                    </div>
                </div>
            @endif


            <ul class="social-icon">
                <li> <a href="#">
                        <h6>Follow Us</h6>
                    </a></li>
                <li> <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                </li>
                <li> <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                </li>
            </ul>
        </div>
    </div>
</div>
