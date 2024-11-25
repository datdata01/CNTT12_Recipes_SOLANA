@extends('admin.layouts.master')
@section('title')
Trang này để thử cho ae nhé :)))
@endsection
@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header"><strong>Sửa Thuộc tính</strong></div>
        <div class="card-body card-block">
            <div class="row form-group">
                <div class="col">
                    <form action="{{ route('attributes.update',$attribute->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" name="name" class="form-control" value="{{$attribute->name}}"
                                value="{{ old('name') }}">
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <a href="{{ route('attributes.index') }}" class="btn btn-secondary">Quay lại</a>
                        <button type="submit" class="btn btn-success">Cập nhật </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection