@extends('admin.layouts.master')
@section('title')
    Đánh Giá Sản Phẩm
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Danh sách Feedback</strong>
        </div>
        <div class="d-flex justify-content-end mx-3 mt-4">
        </div>
        <div class="card-body">
            <ul class="list-unstyled">
                @foreach ($ratingProgress as $stars => $percentage)
                    <li class="d-flex align-items-center mb-3">
                        <p class="font-weight-bold mb-0" style="min-width: 60px;">{{ $stars }} Sao</p>
                        <div class="progress flex-grow-1">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%;"
                                aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $percentage }}%
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <table class="table-bordered table">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Mã Sản phẩm</th>
                        <th scope="col">Tên Khách Hàng</th>
                        <th scope="col">Đánh Giá</th>
                        <th scope="col">Nội Dung</th>
                        <th scope="col">Hình Ảnh</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $feedback)
                        {{-- @dd($feedback) --}}
                        <tr class="text-center">
                            <th scope="row">
                                {{ $loop->iteration }}
                            </th>
                            <td>
                                {{ $feedback->orderItem->productVariant->product->code }}
                                ({{ $feedback->orderItem->productVariant->attributeValues->pluck('name')->implode(' - ') }})
                            </td>
                            <td>{{ $feedback->user->full_name }}</td>
                            <td>
                                @php
                                    $rating = $feedback->rating ? $feedback->rating : 0; // Lấy rating từ feedback
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star" style="color: {{ $i <= $rating ? '#f39c12' : '#000' }};"
                                        aria-hidden="true"></i>
                                @endfor
                            </td>
                            <td>{{ $feedback->comment }}</td>
                            <td><img width="50px" src="{{ '/storage/' . $feedback->file_path }}" alt=""></td>
                            <td>
                                @if ($feedback->replies->isEmpty())
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#feedbackDetailModal-{{ $feedback->id }}">
                                        Chưa trả lời
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#feedbackDetailModal-{{ $feedback->id }}">
                                        Đã trả lời
                                    </button>
                                @endif

                            </td>
                        </tr>
                        @include('admin.pages.feedback.show')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        {{ $feedbacks->links() }}
    </div>
@endsection
