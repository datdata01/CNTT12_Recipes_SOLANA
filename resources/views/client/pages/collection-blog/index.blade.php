@extends('client.layouts.master')
@section('title')
Danh sách bài viết
@endsection
@section('content')
@include('client.pages.components.breadcrumb', [
'pageHeader' => 'Danh sách bài viết',
'parent' => [
'route' => '',
'name' => 'Trang chủ',
],
]);
<section class="section-b-space pt-0">
    <div class="custom-container blog-page container">
        <div class="row gy-4">
            <div class="col-xl-9 col-lg-8 ratio2_3">
                <div class="row gy-4 sticky">
                    @if(isset($category))
                    <h4>Thể loại: {{ $category->name }}</h4>
                    <hr>
                    @endif
                    @if($articles->isEmpty())
                    <p>Không tìm thấy bài viết nào phù hợp với từ khóa "{{ request('query') }}".</p>
                    @else
                    @foreach($articles as $article)
                    <div class="col-12">
                        <div class="blog-main-box blog-list">

                            <div class="list-img">
                                <div class="blog-img">
                                    <img class="img-fluid bg-img" src="{{ asset('storage/' . $article->image) }}"
                                        alt="{{ $article->title }}">
                                </div>
                            </div>
                            <div class="blog-content">
                                <span>
                                    {{ \Carbon\Carbon::parse($article->created_at)->format('d/m/Y')}}
                                </span>
                                <a href="{{ route('blog.show', $article->id) }}">
                                    <h4>{{ $article->title }}</h4>
                                </a>
                                <p>{!! Str::limit(strip_tags($article->content), 200) !!}</p>
                                <div class="share-box">
                                    <a href="{{ route('blog.show',  $article->id) }}"> Xem thêm..</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div class="pagination-wrap mt-0">
                        <ul class="pagination">
                            {{ $articles->links() }}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 order-lg-first">
                <div class="blog-sidebar">
                    <div class="row gy-4">
                        <div class="col-12">
                            <div class="blog-search">
                                <form method="GET" action="{{ route('collection-blog') }}" class="search-form">
                                    <input type="search" name="query" placeholder="Tìm kiếm..."
                                        value="{{ request('query') }}" aria-label="Search" class="search-input">
                                    <span class="search-icon" aria-label="Submit search"
                                        onclick="this.parentElement.submit();">
                                        <i class="iconsax" data-icon="search-normal-2"></i>
                                    </span>
                                </form>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5> Thể loại</h5>
                                </div>
                                <ul class="categories">
                                    @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('category-articles', $category->id) }}">
                                            <p>{{ $category->name }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                <span style="color: red">{{ $category->articles_count }}</span>
                                            </p>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5> Bài viết mới </h5>
                                </div>
                                <ul class="top-post">
                                    @foreach($latestPosts as $post)
                                    <li>
                                        <img class="img-fluid" src="{{ asset('storage/' . $post->image) }}"
                                            alt="{{ $post->title }}">
                                        <div>
                                            <a href="{{ route('blog.show', $post->id) }}">
                                                <h6>{{ $post->title }}</h6>
                                            </a>
                                            <p>{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</p>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sidebar-box">
                                <div class="sidebar-title">
                                    <div class="loader-line"></div>
                                    <h5>Theo dõi chúng tôi</h5>
                                </div>
                                <ul class="social-icon">
                                    <li> <a href="https://www.facebook.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-facebook-f"></i></div>
                                            <h6>Facebook</h6>
                                        </a></li>
                                    <li> <a href="https://www.instagram.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-instagram"> </i></div>
                                            <h6>Instagram</h6>
                                        </a></li>
                                    <li> <a href="https://twitter.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-x-twitter"></i></div>
                                            <h6>Twitter</h6>
                                        </a></li>
                                    <li> <a href="https://www.youtube.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-youtube"></i></div>
                                            <h6>Youtube</h6>
                                        </a></li>
                                    <li> <a href="https://www.whatsapp.com/" target="_blank">
                                            <div class="icon"><i class="fa-brands fa-whatsapp"></i></div>
                                            <h6>Whatsapp</h6>
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col-12 d-none d-lg-block">
                            <div class=".show-offer-box"> <img class="img-fluid"
                                    src="/template/client/assets/images/other-img/blog-offer.jpg" alt="">
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection