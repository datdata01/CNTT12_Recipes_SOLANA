@push('admin-css')
    <style>
        .nav_custom {}
    </style>
@endpush
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default mt-3">
        <div id="main-menu" class="main-menu navbar-collapse collapse" />
        <ul class="nav navbar-nav" style="">
            <li class="">
                <a href="{{ route('dashboard') }}"><i class="menu-icon fa fa-bar-chart"></i>Thống kê</a>
            </li>

            {{-- <li class="menu-title">UI elements</li><!-- /.menu-title --> --}}

            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fa fa-file-text menu-icon"></i>
                    QL Bài viết</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i>
                        <a href="{{ route('category-article.index') }}">Danh mục bài viết</a>
                    </li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('article.index') }}">Danh sách
                            bài viết</a></li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('imagearticle.index') }}">Danh
                            sách hình ảnh</a>
                    </li>
                </ul>
            </li>

            {{-- <li class="menu-item-has-children">
                <a href="{{ route('banner.index') }}"><i class="menu-icon fa fa-book"></i>Quản lý Banner</a>
            </li> --}}

            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-cubes"></i>QL Sản Phẩm
                </a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('products.index') }}">Danh sách
                            sản
                            phẩm</a>
                    </li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('category-product.index') }}">Danh
                            mục sản
                            phẩm</a></li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('attributes.index') }}">Thuộc
                            tính</a></li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('attributeValues.index') }}">Giá
                            trị
                            thuộc
                            tính</a></li>

                </ul>
            </li>

            {{-- <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-th-list"></i>QL Danh mục</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('category-product.index') }}">Danh
                            mục sản
                            phẩm</a></li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('category-article.index') }}">Danh
                            mục bài
                            viết</a></li>
                </ul>
            </li> --}}

            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-users"></i>QL Người Dùng</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('users.index') }}">Danh sách
                            người dùng</a>
                    </li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('roles.index') }}">Vai trò</a>
                    </li>
                </ul>
            </li>

            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-ticket"></i>QL Phiếu Giảm Giá</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('voucher.index') }}">Danh sách </a>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('voucher.create') }}">Thêm mới</a>
                    </li>
                </ul>
            </li>

            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="fa fa-cart-arrow-down menu-icon"></i>
                    QL Đơn Hàng</a>
                <ul class="sub-menu children dropdown-menu">
                    <li>
                        <i class="fa fa-caret-square-o-right"></i>
                        <a href="{{ route('orders.index') }}">Danh sách đơn hàng</a>
                    </li>
                    <li>
                        <i class="fa fa-caret-square-o-right"></i>
                        <a href="{{ route('refund.index') }}">Danh sách đơn hoàn</a>
                    </li>
                </ul>
            </li>

            {{-- <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-book"></i>QL sản phẩm</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-list"></i><a href="{{ route('products.index') }}">Danh sách</a></li>
                </ul>
            </li> --}}

            {{-- <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-list-alt"></i>Đơn hàng</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-list"></i><a href="{{ route('orders.index') }}">Tất cả đơn hàng</a></li>
                </ul>
            </li> --}}


            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-comments"></i>QL Phản Hồi</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('feedback.index') }}">Danh sách</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-cogs"></i>Cấu hình</a>
                <ul class="sub-menu children dropdown-menu">
                    <li>
                        <i class="fa fa fa-picture-o"></i>
                        <a href="{{ route('banner.index') }}">QL Banner</a>
                    </li>
                </ul>
            </li>
        </ul>
        </div>
    </nav>
</aside>
