@extends('admin.layouts.master')
@section('title')
    Tổng quan
@endsection
@section('content')
    <div class="animated fadeIn">
        <!-- Widgets  -->
        {{-- <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="pe-7s-cash"></i>
                            </div>
                            <div class="stat-content">
                                <div class="dib text-left">
                                    <div class="stat-text">$<span class="count">23569</span></div>
                                    <div class="stat-heading">Revenue</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-2">
                                <i class="pe-7s-cart"></i>
                            </div>
                            <div class="stat-content">
                                <div class="dib text-left">
                                    <div class="stat-text"><span class="count">3435</span></div>
                                    <div class="stat-heading">Sales</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-3">
                                <i class="pe-7s-browser"></i>
                            </div>
                            <div class="stat-content">
                                <div class="dib text-left">
                                    <div class="stat-text"><span class="count">349</span></div>
                                    <div class="stat-heading">Templates</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-4">
                                <i class="pe-7s-users"></i>
                            </div>
                            <div class="stat-content">
                                <div class="dib text-left">
                                    <div class="stat-text"><span class="count">2986</span></div>
                                    <div class="stat-heading">Clients</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Widgets -->


        <div class="col-sm-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card bg-flat-color-1 text-white">
                        <div class="card-body">
                            <div class="card-left float-left pt-1" style="width:220px;z-index: 10">
                                <h3 class="fw-r mb-0">
                                    <span>{{ number_format($totalCompleted, 0, ',', '.') }}<span class="currency mr-1 mt-1"
                                            style="font-size: 12px;">VND</span></span>
                                </h3>
                                <p class="text-light m-0 mt-1">Tổng Doanh thu</p>
                            </div><!-- /.card-left -->
                        </div>

                    </div>
                </div>
                <!--/.col-->

                <div class="col-sm-6 col-lg-3">
                    <div class="card bg-flat-color-6 text-white">
                        <div class="card-body">
                            <div class="card-left float-left pt-1">
                                <h3 class="fw-r mb-0">
                                    <span class="count float-left">{{ $successRate }}</span>
                                    <span>%</span>
                                </h3>
                                <p class="text-light m-0 mt-1" style="width:250px">Tỷ lệ đơn hàng thành công </p>
                            </div><!-- /.card-left -->

                            <div class="card-right float-right text-right">
                                <i class="icon fade-5 pe-7s-cart" style="font-size: 3.68em;"></i>
                            </div><!-- /.card-right -->

                        </div>

                    </div>
                </div>
                <!--/.col-->

                <div class="col-sm-6 col-lg-3">
                    <div class="card bg-flat-color-3 text-white">
                        <div class="card-body">
                            <div class="card-left float-left pt-1" style="width:220px;z-index: 10">
                                <h3 class="fw-r mb-0">
                                    <span>{{ number_format($totalTodayRevenue, 0, ',', '.') }}<span
                                            class="currency mr-1 mt-1" style="font-size: 12px;">VND</span></span>
                                </h3>
                                <p class="text-light m-0 mt-1" style="width:250px">Doanh thu trong ngày</p>
                            </div><!-- /.card-left -->
                        </div>

                    </div>
                </div>
                <!--/.col-->

                <div class="col-sm-6 col-lg-3">
                    <div class="card bg-flat-color-2 text-white">
                        <div class="card-body">
                            <div class="card-left float-left pt-1">
                                <h3 class="fw-r mb-0">
                                    <span class="count">{{ $newUsers }}</span>
                                </h3>
                                <p class="text-light m-0 mt-1">Người dùng mới</p>
                            </div><!-- /.card-left -->

                            <div class="card-right float-right text-right">
                                <i class="fa fa-user-plus icon fade-5" style="font-size: 3.68em;"></i>
                            </div><!-- /.card-right -->

                        </div>

                    </div>
                </div>
                <!--/.col-->
            </div>
        </div>

        <div class="col-sm-12 mb-4">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-four">
                                <div class="stat-icon dib">
                                    <i class="fa fa-cubes text-muted"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="dib text-left">
                                        <div class="stat-heading">SL sản phẩm</div>
                                        <div class="stat-text">Còn hàng: {{ $totalProduct }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-four">
                                <div class="stat-icon dib">
                                    <i class="fa fa-cart-arrow-down text-muted"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="dib text-left">
                                        <div class="stat-heading">SL đơn hàng</div>
                                        <div class="stat-text">Tổng số: {{ $totalOrders }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-four">
                                <div class="stat-icon dib">
                                    <i class="fa fa-comments text-muted"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="dib text-left">
                                        <div class="stat-heading">SL đánh giá</div>
                                        <div class="stat-text">Tổng số: {{ $feedbackCount }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-four">
                                <div class="stat-icon dib">
                                    <i class="fa fa-file-text text-muted"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="dib text-left">
                                        <div class="stat-heading">SL bài viết</div>
                                        <div class="stat-text">Tổng số: {{ $totalArticles }} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mb-4">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-four">
                                <div class="stat-icon dib">
                                    <i class="fa fa-users text-muted"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="dib text-left">
                                        <div class="stat-heading">Khách hàng</div>
                                        <div class="stat-text">Tổng số: {{ $totalUsers }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-four">
                                <div class="dib text-left">
                                    <div class="stat-heading">Sản phẩm hết hàng</div>
                                    <div class="stat-text">Tổng số: {{ $inactiveProductsCount }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="col-sm-12 mb-4">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib"><i class="fa fa-usd text-success border-success"
                                            style="font-size: 15px; padding: 5px;"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="stat-text">ĐH thành công</div>
                                    </div>
                                </div>
                                <div class="dib mt-1">

                                    <div class="stat-digit">Tổng số: {{ $completedOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib"><i class="fa fa-check text-primary border-primary"
                                            style="font-size: 15px; padding: 5px;"></i></div>
                                    <div class="ml-3">
                                        <div class="stat-text">ĐH đã giao</div>
                                    </div>
                                </div>
                                <div class="dib mt-1">
                                    <div class="stat-digit">Tổng số: {{ $shippedOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib">
                                        <i class="fa fa-truck text-info border-info"
                                            style="font-size: 15px; padding: 5px;"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="stat-text">ĐH đang giao</div>
                                    </div>
                                </div>

                                <div class="dib mt-1">
                                    <div class="stat-digit">Tổng số: {{ $deliveringOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib">
                                        <i class="fa fa-bell text-warning border-warning"
                                            style="font-size: 15px; padding: 5px;"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="stat-text">ĐH chờ xử lý</div>
                                    </div>
                                </div>
                                <div class="dib mt-1">
                                    <div class="stat-digit">Tổng số: {{ $pendingOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="stat-widget-one">
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon dib"><i class="fa fa-times text-danger border-danger"
                                            style="font-size: 15px; padding: 5px;"></i></div>
                                    <div class="ml-3">
                                        <div class="stat-text">ĐH đã hủy</div>
                                    </div>
                                </div>
                                <div class="dib mt-1">
                                    <div class="stat-digit">Tổng số: {{ $cancelledOrders }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        @include('admin.pages.dashboard.components.product-sales-analysis')
        @include('admin.pages.dashboard.components.monthly-revenue-chart')



    </div>
@endsection
