@extends('client.pages.profile.layouts.master')

@section('title')
Lịch sử mua hàng
@endsection

@section('profile')
<div class="dashboard-right-box">
    <div class="order">
        <div class="sidebar-title">
            <div class="product-section-box x-small-section pt-0">
                <div class="custom-container container">
                    <div class="row">
                        <div class="loader-line"></div>
                        <h4>Lịch sử đơn hàng</h4>
                    </div>
                    <div class="col-12">
                        <ul class="product-tab theme-scrollbar nav nav-tabs nav-underline" id="Product" role="tablist">
                            @php
                                $tabs = [
                                    'PENDING' => 'Đang chờ xử lý',
                                    'DELIVERING' => 'Đang giao hàng',
                                    'SHIPPED' => 'Đã giao hàng',
                                    'COMPLETED' => 'Thành công',
                                    'CANCELED' => 'Hủy đơn hàng'
                                ];
                            @endphp
                            @foreach ($tabs as $status => $tabName)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $status }}-tab"
                                        data-bs-toggle="tab" data-bs-target="#{{ $status }}-tab-pane" role="tab"
                                        aria-controls="{{ $status }}-tab-pane"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $tabName }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content product-content" id="ProductContent">
                            @foreach ($tabs as $status => $tabName)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ $status }}-tab-pane" role="tabpanel" aria-labelledby="{{ $status }}-tab"
                                    tabindex="0">
                                    <div class="row gy-4">
                                        @foreach ($orders as $item)
                                            @if ($item->status === $status)
                                                <div class="col-12">
                                                    <div class="order-box">
                                                        <div class="order-container">
                                                            <div class="order-icon">
                                                                <i class="iconsax" data-icon="box"></i>
                                                                <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                                            </div>
                                                            <div class="order-detail d-flex flex-wrap">
                                                                <!-- Cột trái -->
                                                                <div class="order-detail-left"
                                                                    style="flex: 1; min-width: 250px; padding-right: 15px;">
                                                                    <h5>{{ $tabName }}</h5>
                                                                    <p>Ngày đặt đơn:
                                                                        {{ date('d/m/Y', strtotime($item->created_at)) }}</p>
                                                                    <p>Người nhận: {{ $item->customer_name }}</p>
                                                                    <p>Số điện thoại: {{ $item->phone }}</p>
                                                                </div>
                                                                <!-- Cột phải -->
                                                                <div class="order-detail-right" style="flex: 1; min-width: 250px; ">
                                                                    <p>Địa chỉ giao hàng: {{ $item->full_address }}</p>
                                                                    <p>Mã đơn hàng: <span>{{ $item->code }}</span></p>
                                                                    <p>Ghi chú đơn hàng: {{ $item->note }}</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="product-order-detail">
                                                            @foreach ($item->orderItems as $orderItem)
                                                                <div class="product-box mb-3">
                                                                    <a
                                                                        href="{{ route('product', $orderItem->productVariant->product->id) }}">
                                                                        <img src="{{ '/storage/' . $orderItem->productVariant->product->image }}"
                                                                            style="object-fit: cover;"
                                                                            alt="{{ $orderItem->productVariant->product->name }}">
                                                                    </a>
                                                                    <div class="order-wrap">
                                                                        <h5>{{ $orderItem->product_name }}</h5>
                                                                        <ul>
                                                                            <li>
                                                                                <p>Giá:</p>
                                                                                <span>{{ number_format($orderItem->product_price) }}
                                                                                    Vnd</span>
                                                                            </li>
                                                                            <li>
                                                                                <p>Số lượng:</p><span>{{ $orderItem->quantity }}</span>
                                                                            </li>
                                                                            <li>
                                                                                <p>Biến thể:</p>
                                                                                <span>{{ $orderItem->productVariant->attributeValues->pluck('name')->implode(' - ') }}</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                            @endforeach
                                                        </div>
                                                        <div class="text-center mt-3">
                                                            <a style="background-color: #c28f51; border:none;"
                                                                href="{{ route('profile.order.details', $item->id) }}"
                                                                class="btn btn-primary">Xem chi tiết đơn hàng</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
