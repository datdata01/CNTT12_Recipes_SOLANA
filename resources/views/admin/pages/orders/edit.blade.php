@extends('admin.layouts.master')

@section('title')
    Cập nhật trạng thái đơn hàng
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Mã đơn hàng: {{ $order->code }}</strong>
        </div>
        <form action="{{ route('orders.update', $order->id) }}" method="post">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="">
                            <h3>Thông tin đặt hàng</h3>
                            <div class="mx-4">
                                <ul>
                                    <li>
                                        <h6>Người nhận: {{ $order->customer_name }}</h6>
                                    </li>
                                    <li>
                                        <h6>Số điện thoại: {{ $order->phone }}</h6>
                                    </li>
                                    <li>
                                        <h6>Địa chỉ: <span>{{ $order->full_address }}</span></h6>
                                    </li>
                                    <li>
                                        <h5>Ngày đặt: {{ $order->created_at->format(' H:i:s d-m-Y') }}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sản phẩm </th>
                                        <th>Giá </th>
                                        <th>Số lượng</th>
                                        <th>Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <a href="product.html">
                                                            <img src="{{ '/Storage/' . $item->productVariant->product->image }}"
                                                                alt="Ảnh sản phẩm">
                                                        </a>
                                                    </div>
                                                    <div class="col-8">
                                                        <h5> {{ $item->product_name }}</h5>
                                                        @foreach ($item->productVariant->attributeValues as $attributeValue)
                                                            <p>{{ $attributeValue->attribute->name }}:
                                                                <span>{{ $attributeValue->name }}</span>
                                                            </p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ number_format($item->product_price) }}đ</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->total_price) }}đ</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td> </td>
                                        <td></td>
                                        <td class="total fw-bold">Tổng: </td>
                                        <td class="total fw-bold ">{{ number_format($order->total_amount) }}đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="col-4">
                        <div>
                            <strong>Chuyển đổi trạng thái đơn hàng</strong>
                        </div>
                        <div>
                            <div class="mb-3 mt-3">
                                <h4 class="mb-3 mt-3">Trạng thái hiện tại:
                                    @if ($order->status == 'PENDING')
                                        <span class="badge bg-primary">Đang chờ xử lý</span>
                                    @elseif ($order->status === 'DELIVERING')
                                        <span class="badge bg-primary">Đang giao hàng</span>
                                    @elseif ($order->status === 'SHIPPED')
                                        <span class="badge bg-primary">Đã giao hàng</span>
                                    @elseif ($order->status == 'COMPLETED')
                                        <span class="badge bg-primary">Thành công</span>
                                    @elseif ($order->status === 'CANCELED')
                                        <span class="badge bg-danger">Đã Huỷ</span>
                                    @endif
                                </h4>
                                @if ($order->status === 'PENDING')
                                    <button type="submit" name="status" value="DELIVERING" class="btn btn-warning">Đang
                                        giao hàng</button>
                                    <button type="submit" name="status" value="CANCELED" class="btn btn-danger">Huỷ đơn
                                        hàng</button>
                                @elseif ($order->status === 'DELIVERING')
                                    <button type="submit" name="status" value="SHIPPED" class="btn btn-info">Đã giao
                                        hàng</button>
                                    <button type="submit" name="status" value="CANCELED" class="btn btn-danger">Huỷ đơn
                                        hàng</button>
                                    {{-- @elseif ($order->status === 'SHIPPED')
                                    <button type="submit" name="status" value="COMPLETED" class="btn btn-success">Giao
                                        hàng thành công</button> --}}
                                @elseif ($order->status === 'COMPLETED')
                                    <div class="alert alert-success">Đơn hàng đã hoàn tất.</div>
                                @elseif ($order->status === 'CANCELED')
                                    <div class="alert alert-danger">Đơn hàng đã bị hủy.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


                <div>
                    <a href="{{ route('orders.index') }}" class="btn btn-primary">Quay lại</a>

                </div>
            </div>
        </form>
    </div>
@endsection
