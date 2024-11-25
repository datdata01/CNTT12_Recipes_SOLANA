<div class="custom-container container">
    <div class="row">
        <div class="col">
            <div class="title-1">
                <p>Theo dõi chúng tôi<span></span></p>
                <h3>Bài viết</h3>
            </div>
        </div>
    </div>
    <div class="swiper insta-slide-3">
        <div class="swiper-wrapper">
            @foreach ($blogArticles as $post)
                <div class="swiper-slide">
                    <div class="instagram-box-1">
                        <div class="instagram-box">
                            <div class="instashop-effect">
                                <img style="object-fit: cover; width: 300px; height: 400px;" class="img-fluid"
                                    src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                                <div class="insta-txt">
                                    <div>
                                        <svg class="insta-icon">
                                            <use href="/template/client/assets/svg/icon-sprite.svg#instagram"></use>
                                        </svg>
                                        <p>Bài viết</p>
                                        <div class="link-hover-anim underline">
                                            <a class="btn btn_underline link-strong link-strong-unhovered"
                                                href="{{ route('blog.show', $post->id) }}">Xem thêm
                                                <svg>
                                                    <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                                                </svg>
                                            </a>
                                            <a class="btn btn_underline link-strong link-strong-hovered"
                                                href="{{ route('blog.show', $post->id) }}">Xem thêm
                                                <svg>
                                                    <use href="/template/client/assets/svg/icon-sprite.svg#arrow"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
