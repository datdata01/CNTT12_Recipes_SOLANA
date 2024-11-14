<!DOCTYPE html>
<html lang="en">

    <head>
        <title>
            @yield('title')
        </title>
        @include('client.layouts.partials.css')
        @stack('css')

    </head>

    <body class="skeleton_body">
        <!--bottom to top-->
        <div class="tap-top">
            <div>
                <i class="fa-solid fa-angle-up"></i>
            </div>
        </div>
        <!-- hieu ung chuot
        <span class="cursor">
            <span class="cursor-move-inner"><span class="cursor-inner"></span></span><span
                class="cursor-move-outer"><span class="cursor-outer"></span></span>
        </span> -->

        <!-- Load trang trang truoc khi co du lieu-->
        <div class="skeleton_loader">
            @include('client.layouts.partials.header.loader')
        </div>

        <!-- header khi co du lieu-->
        <header>
            <!-- Quảng cáo header -->
            {{-- <div class="top_header">
                <p>Free Coupne Code: Summer Sale On Selected items Use:<span>NEW 26</span><a
                        href="collection-left-sidebar.html"> SHOP NOW</a></p>
            </div> --}}
            <!-- menu logo cac kieu-->
            {{-- @include('client.layouts.partials.header.header-menu') --}}
            <x-header-component />
        </header>
        <!-- content -->
        @yield('content')

        <!--footer-->
        @include('client.layouts.partials.footer')


        <!-- cart item
            <div class="offcanvas offcanvas-end shopping-details" id="offcanvasRight" tabindex="-1"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <h4 class="offcanvas-title" id="offcanvasRightLabel">Shopping Cart</h4><button class="btn-close"
                    type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body theme-scrollbar">
                <ul class="offcanvas-cart">
                    <li> <a href="#"> <img src="/template/client/assets/images/cart/1.jpg"
                                alt="" /></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity-previous">2</div>
                                        <div id="quantity-current">3</div>
                                        <div id="quantity-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="/template/client/assets/images/cart/2.jpg"
                                alt="" /></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total1">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove1">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity1-previous">2</div>
                                        <div id="quantity1-current">3</div>
                                        <div id="quantity1-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add1">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="/template/client/assets/images/cart/3.jpg"
                                alt="" /></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total2">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove2">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity2-previous">2</div>
                                        <div id="quantity2-current">3</div>
                                        <div id="quantity2-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add2">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                    <li> <a href="#"> <img src="/template/client/assets/images/cart/4.jpg"
                                alt="" /></a>
                        <div>
                            <h6 class="mb-0">Shirts Men's Clothing</h6>
                            <p>$35<del>$40</del><span class="btn-cart">$<span class="btn-cart__total"
                                        id="total3">105</span></span></p>
                            <div class="btn-containter">
                                <div class="btn-control"><button class="btn-control__remove"
                                        id="btn-remove3">&minus;</button>
                                    <div class="btn-control__quantity">
                                        <div id="quantity3-previous">2</div>
                                        <div id="quantity3-current">3</div>
                                        <div id="quantity3-next">4</div>
                                    </div><button class="btn-control__add" id="btn-add3">+</button>
                                </div>
                            </div>
                        </div><i class="iconsax delete-icon" data-icon="trash"></i>
                    </li>
                </ul>
            </div>
            <div class="offcanvas-footer">
                <p>Spend <span>$ 14.81 </span>more and enjoy <span>FREE SHIPPING!</span></p>
                <div class="footer-range-slider">
                    <div class="progress" role="progressbar" aria-label="Animated striped example"
                        aria-valuenow="46" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated theme-default"
                            style="width: 46%"></div>
                    </div>
                </div>
                <div class="price-box">
                    <h6>Total :</h6>
                    <p>$ 49.59 USD</p>
                </div>
                <div class="cart-button"> <a class="btn btn_outline" href="cart.html"> View Cart</a><a
                        class="btn btn_black" href="check-out.html"> Checkout</a></div>
            </div>
        </div> -->

        <!--Search-->
        @include('client.layouts.components.search')

        <div class="theme-btns"><button class="btntheme" id="dark-btn"><i class="fa-regular fa-moon"></i>
                <div class="text">Dark</div>
            </button><button class="btntheme rtlBtnEl" id="rtl-btn"><i class="fa-solid fa-repeat"></i>
                <div class="rtl">Rtl</div>
            </button></div>

        @include('client.layouts.partials.script')
        @stack('scripts')
    </body>

</html>
