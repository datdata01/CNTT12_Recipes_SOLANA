<div class="container-fluid subscribe-banner">
    <div class="row align-items-center">
        <div class="col-xl-8 col-md-7 col-12 px-0">
            @if ($subscribeNowEmailBanners)
                <a href="{{ $subscribeNowEmailBanners->link }}"><img class="bg-img"
                        src="{{ asset('storage/' . $subscribeNowEmailBanners->image_url) }}" alt="" />
                </a>
            @else
                <a href="index.html"><img class="bg-img" src="/template/client/assets/images/banner/banner-6.png"
                        alt="" /></a>
            @endif
        </div>
        <div class="col-xl-4 col-5">
            <div class="subscribe-content">
                <h6>NHẬN GIẢM GIÁ 20%</h6>
                <h4>Đăng ký để nhận ngay!</h4>
                <p>Tham gia để nhận được nhưng khuyến mãi tốt nhất</p><input type="text" name="text"
                    placeholder="Địa chỉ email của bạn..." />
                <div class="link-hover-anim underline"><a class="btn btn_underline link-strong link-strong-unhovered"
                        href="index.html">Đăng ký ngay<svg>
                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                        </svg></a><a class="btn btn_underline link-strong link-strong-hovered" href="index.html">Đăng ký
                        ngay<svg>
                            <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                        </svg></a></div>
            </div>
        </div>
    </div>
</div>
