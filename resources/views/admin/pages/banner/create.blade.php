@extends('admin.layouts.master')

@section('title', 'Thêm mới Banner')

@section('content')
<div class="card">
    <div class="card-header ">Thêm mới Banner</div>
    <div class="card-body card-block">
        <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Tiêu đề ảnh:</label>
                            <input type="text" name="title" class="form-control" 
                            placeholder="Tiêu đề ảnh" value="{{ old('title') }}" >
                            @error('title')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-md-12">
                            <label for="image" class="form-label">Chọn ảnh:</label>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            @if (old('image'))
                    <input type="hidden" name="old_image" value="{{ old('image') }}">
                            @endif
                            @error('image')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="image_type" class="form-label">Chọn vị trí hình ảnh:</label>
                            <select name="image_type" class="form-select">
                            <option value="HEADER" {{ old('image_type') == 'HEADER' ? 'selected' : '' }}>Banner Header</option>
                            <option value="CONTENT-LEFT-TOP" {{ old('image_type') == 'CONTENT-LEFT-TOP' ? 'selected' : '' }}>Banner Content-left-top</option>
                            <option value="CONTENT-LEFT-BELOW" {{ old('image_type') == 'CONTENT-LEFT-BELOW' ? 'selected' : '' }}>Banner Content-left-right</option>
                            <option value="CONTENT-RIGHT" {{ old('image_type') == 'CONTENT-RIGHT' ? 'selected' : '' }}>Banner Content-right</option>
                            <option value="SUBSCRIBE-NOW-EMAIL" {{ old('image_type') == 'SUBSCRIBE-NOW-EMAIL' ? 'selected' : '' }}>Banner subscribe-now-email</option>
                            <option value="BANNER-LEFT" {{ old('image_type') == 'BANNER-LEFT' ? 'selected' : '' }}>Banner-left</option>
                            <option value="BANNER-RIGHT" {{ old('image_type') == 'BANNER-RIGHT' ? 'selected' : '' }}>Banner-right</option>
                            </select>                    
                            @error('image_type')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="link" class="form-label">Đường dẫn sản phẩm/ bài viết:</label>
                            <input type="text" name="link" class="form-control" placeholder="Link" value="{{ old('link') }}">
                            @error('link')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4>Ghi chú:</h4> <br>
                    <p>HEADER yêu cầu kích thước tối đa 1600x650</p>
                    <p>CONTENT-LEFT-TOP yêu cầu 650x300</p>
                    <p>CONTENT-LEFT-BELOW yêu cầu 650x300</p>
                    <p>CONTENT-RIGHT yêu cầu 500x550</p>
                    <p>SUBSCRIBE-NOW-EMAIL yêu cầu 1100x700</p>
                    <p>BANNER-LEFT yêu cầu 700x700</p>
                    <p>BANNER-RIGHT yêu cầu 700x500</p>

                </div>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>
                <a href="{{ route('banner.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
            </div>
        </form>
    </div>
</div>



@endsection