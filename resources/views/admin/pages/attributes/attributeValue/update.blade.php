@extends('admin.layouts.master')
@section('title')
    Trang này để thử cho ae nhé :)))
@endsection
@section('content')
<div class="col-lg-6">
    <div class="card">
        <div class="card-header"><strong>Sửa thuộc tính</strong></div>
        <div class="card-body card-block">
            <div class="row form-group">
                <div class="col">
                    <form action="{{ route('attributeValues.update',$attributeValue->id) }}" method="POST">
                        @csrf
                        @method('PUT') 
                        <div class="form-group">
                            <select class="form-control" name="attribute_id">
                                <option value="" disabled selected>Chọn loại thuộc tính</option>
                                @foreach ($listAttributes as $attribute)
                                    <option value="{{ $attribute->id }}" {{ $attribute->id == $attributeValue->attribute_id ? 'selected' : '' }} >{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                            @error('attribute_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" name="name" class="form-control" value="{{$attributeValue->name}}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <a href="{{ route('attributeValues.index') }}" class="btn btn-secondary">Quay lại</a>

                        <button type="submit" class="btn btn-success">Cập nhật </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
