@extends('admin.layouts.master')
@section('title')
    Danh sách hoàn hàng
@endsection
@section('content')
    <div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Danh sách hoàn hàng</strong>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID đơn hàng</th>
                                <th scope="col">Lý do</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listRefund as $index => $list)
                                <tr>
                                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                    <td class="text-center">{{ $list->order->id ?? 'Không có mã order_id' }}</td>
                                    <td class="text-center">{{ $list->reason }}</td>
                                    <td class="text-center">{{ $list->description }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $list->image) }}" alt="" width="100px"
                                            height="100px">
                                    </td>
                                    <td class="text-center">{{ $list->status }}</td>
                                    <td class="text-center">

                                        <a type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#refundDetailModal-{{ $list->id }}">
                                            <i class="fa fa-info-circle"></i>
                                        </a>
                                        {{-- 
                                        <a href="{{ route('refund.edit', $list->id) }}" class="btn btn-warning">
                                            <i class="fa fa-pencil"></i>
                                        </a> --}}
                                    </td>
                                </tr>
                                @include('admin.pages.refund.show')
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $listRefund->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
