<div class="custom-container container">
    <div class="style-banner">
        @if ($leftBanners)
            <div class="row gy-4 align-items-end">
            <div class="col-sm-6 col-12 ratio_square-4"><a href="{{$leftBanners->link}}"> <img class="bg-img"
                        src="{{ asset('storage/' . $leftBanners->image_url) }}" alt="" /></a></div>
        @else
        <img class="bg-img"
        src="/template/client/assets/images/banner/banner-4.png" alt="" /></a></div>
        @endif
        @if ($rightBanners)
           <div class="col-sm-6 col-12 ratio3_2">
                <div class="style-content">
                    
                    <h2>{{$rightBanners->title}}</h2>
                    <div class="link-hover-anim underline"><a
                            class="btn btn_underline link-strong link-strong-unhovered"
                            href="{{$rightBanners->link}}">Xem thêm<svg>
                                <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a><a class="btn btn_underline link-strong link-strong-hovered"
                            href="{{$rightBanners->link}}">Xem thêm<svg>
                                <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                            </svg></a></div>
                </div><a href="{{$rightBanners->link}}"> <img class="bg-img"
                        src="{{ asset('storage/' . $rightBanners->image_url) }}" alt="" /></a>
            </div> 
        @else
        <img class="bg-img"
        src="/template/client/assets/images/banner/banner-5.jpg" alt="" /></a>
        @endif
            
        </div>
    </div>
</div>
