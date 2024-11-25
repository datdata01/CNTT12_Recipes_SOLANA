@push('admin-css')
    <style>
        .nav_custom {}
    </style>
@endpush
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default mt-3">
        <div id="main-menu" class="main-menu navbar-collapse collapse" />
        <ul class="nav navbar-nav" style="">
        @can('dashboard')
            <li class="">
                <a href="{{ route('dashboard') }}"><i class="menu-icon fa fa-bar-chart"></i>Thống kê</a>
            </li>
        @endcan

            @can('articles')
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
                </ul>
            </li>
            @endcan

            @can('products')
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
            @endcan
            @can('voucher')
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-ticket"></i>QL Phiếu Giảm Giá</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('voucher.index') }}">Danh sách </a>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('voucher.create') }}">Thêm mới</a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('users')
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-users"></i>QL Người Dùng</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('new-user.index') }}">Danh sách
                            người dùng</a>
                    </li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('permission.index') }}">Quyền tài khoản</a>
                    </li>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('new-role.index') }}">Vai trò tài khoản</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('vouchers')
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-ticket"></i>QL Phiếu Giảm Giá</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('voucher.index') }}">Danh sách </a>
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('voucher.create') }}">Thêm mới</a>
                    </li>
                </ul>
            </li>
            @endcan
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="menu-icon fa fa-cart-arrow-down menu-icon"></i>
                    QL Đơn Hàng</a>
                <ul class="sub-menu children dropdown-menu">
                @can('orders')
                    <li>
                        <i class="fa fa-caret-square-o-right"></i>
                        <a href="{{ route('orders.index') }}">Danh sách đơn hàng</a>
                    </li>
                @endcan
                @can('refund')
                    <li>
                        <i class="fa fa-caret-square-o-right"></i>
                        <a href="{{ route('refund.index') }}">Danh sách đơn hoàn</a>
                    </li>
                @endcan
                </ul>
            </li>


            @can('feedback')
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"><i class="menu-icon fa fa-comments"></i>QL Phản Hồi</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="fa fa-caret-square-o-right"></i><a href="{{ route('feedback.index') }}">Danh sách</a>
                    </li>
                </ul>
            </li>
            @endcan

            @can('banner')
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
            @endcan
        </ul>
        </div>
    </nav>
</aside>
