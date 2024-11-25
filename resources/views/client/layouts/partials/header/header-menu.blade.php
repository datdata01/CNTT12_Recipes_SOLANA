{{-- @dd($categoryProduct) --}}
<div class="custom-container header-1 container">
    <div class="row">
        <div class="col-12 p-0">
            <div class="mobile-fix-option">
                <ul>
                    <li>
                        <a href="index.html"><i class="iconsax" data-icon="home-1"></i>Trang chủ</a>
                    </li>
                    <li><a href="search.html"><i class="iconsax" data-icon="search-normal-2"></i>Search</a>
                    </li>
                    <li class="shopping-cart"> <a href="cart.html"><i class="iconsax"
                                data-icon="shopping-cart"></i>Cart</a></li>
                    {{-- <li>
                        <a href="wishlist.html">
                            <i class="iconsax" data-icon="heart"></i>My Wish
                        </a>
                    </li> --}}
                    <li> <a href="dashboard.html"><i class="iconsax" data-icon="user-2"></i>Account</a>
                    </li>
                </ul>
            </div>
            <div class="offcanvas offcanvas-start" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1"
                aria-labelledby="staticBackdropLabel">
                <div class="offcanvas-header">
                    <h3 class="offcanvas-title" id="staticBackdropLabel">Offcanvas</h3><button class="btn-close"
                        type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div></div>I will not close if you click outside of me.
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="main-menu">
                <a class="brand-logo" href="{{ route('home') }}">
                    <img class="img-fluid for-light"
                        src="/template/client/assets/images/logo/logoGumdamWin-removebg-preview.png" alt="logo" />
                    <img class="img-fluid for-dark"
                        src="/template/client/assets/images/logo/logoGW01-removebg-preview.png" alt="logo" />
                </a>
                <nav id="main-nav">
                    <ul class="nav-menu sm-horizontal theme-scrollbar" id="sm-horizontal">
                        <li class="mobile-back" id="mobile-back">Back
                            <i class="fa-solid fa-angle-right ps-2" aria-hidden="true"></i>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('home') }}">Trang chủ
                            </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('collection-product') }}">Sản phẩm
                                <span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="nav-submenu">
                                @isset($categoryProduct)
                                    @foreach ($categoryProduct as $cate)
                                        {{-- @dd($cate) --}}
                                        <li>
                                            <a href="{{ route('collection-product', ['id' => $cate->id]) }}">
                                                {{ $cate->name }} </a>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </li>

                        <li>
                            <a class="nav-link" href="{{ route('collection-blog') }}">Bài viết
                                <span>
                                    <i class="fa-solid fa-angle-down"></i>
                                </span>
                            </a>
                            <ul class="nav-submenu">
                                @isset($categoryArticle)
                                    @foreach ($categoryArticle as $cate)
                                        <li>
                                            <a href="{{ route('collection-blog', $cate->id) }}"> {{ $cate->name }} </a>
                                        </li>
                                    @endforeach
                                @endisset
                            </ul>
                        </li>
                        <li> <a class="nav-link" href="{{ route('contact') }}">Liên hệ </a></li>
                    </ul>
                </nav>
                <div class="sub_header">
                    <div class="toggle-nav" id="toggle-nav"><i class="fa-solid fa-bars-staggered sidebar-bar"></i>
                    </div>
                    <ul class="justify-content-end">
                        <li>
                            <button href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop"
                                aria-controls="offcanvasTop">
                                <i class="iconsax" data-icon="search-normal-2"></i>
                            </button>
                        </li>

                        <li class="onhover-div">
                            <a href="#">
                                <i class="iconsax" data-icon="user-2"></i>
                            </a>
                            @if (Auth::id())
                                <!-- Người dùng đã đăng nhập -->
                                <div class="onhover-show-div user" style="width: 200px;">
                                    <ul>
                                        @php
                                            // Lấy role_id từ bảng user_roles
                                            $roleIds = \DB::table('user_roles')
                                                ->where('user_id', Auth::id())
                                                ->pluck('role_id')
                                                ->toArray();
                                        @endphp
                                        @if (in_array(2, $roleIds))
                                            <li><a href="{{ route('dashboard') }}">Trang quản lý</a></li>
                                        @endif
                                        <li><a href="{{ route('profile.infomation') }}">Thông tin tài khoản</a></li>
                                        <li><a href="{{ route('profile.order-history') }}">Lịch sử mua hàng</a></li>
                                        <li>
                                            <!-- Form đăng xuất để xử lý bằng phương thức POST -->
                                            <form action="{{ route('auth.logout') }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                <button type="submit" title="Đăng xuất"
                                                    style="background: none; border: none; padding: 0; cursor: pointer; text-decoration: none;">
                                                    <a>Đăng xuất</a>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <!--Nếu người dùng chưa đăng nhập nhé-->
                                <div class="onhover-show-div user">
                                    <ul>
                                        <li> <a href="{{ route('auth.login-view') }}">Đăng nhập </a></li>
                                        <li> <a href="{{ route('auth.register-view') }}">Đăng ký</a></li>
                                    </ul>
                                </div>
                            @endif
                        </li>
                        @if (Auth::id())
                            <li>
                                <a href="{{ route('wish-list') }}">
                                    <i class="iconsax" data-icon="heart"></i>
                                    <span id="love" class="cart_qty_cls">{{ $love }}</span>
                                </a>
                            </li>
                            <li class="onhover-div shopping-cart">
                                <a class="p-0" href="{{ route('cart') }}">
                                    <div class="shoping-prize">
                                        <i class="iconsax pe-2" data-icon="basket-2"></i>
                                        <span id="numberCart"> {{ $numberCart }} </span>
                                    </div>
                                </a>
                            </li>
                        @else
                            <li>
                                <div class="p-0">
                                    <div class="shoping-prize">
                                        <i class="iconsax" data-icon="heart"></i>
                                    </div>
                                </div>
                                <div class="onhover-show-div user" style="width:200px">
                                    <ul>
                                        <li>
                                            <p>Vui lòng đăng nhập !</p>
                                        </li>
                                    </ul>
                                </div>

                            </li>
                            <li>
                                <div class="p-0">
                                    <div class="shoping-prize">
                                        <i class="iconsax pe-2" data-icon="basket-2"></i>0

                                    </div>
                                </div>
                                <div class="onhover-show-div user" style="width:200px">
                                    <ul>
                                        <li>
                                            <p>Vui lòng đăng nhập !</p>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
