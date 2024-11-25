@extends('admin.layouts.master')
@section('title')
    Thêm mới bài viết
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong>Thêm mới bài viết</strong>
            </div>
            <div class="card-body card-block">
                <form action="{{ route('article.store') }}" method="post" enctype="multipart/form-data"
                    class="form-horizontal">
                    @csrf
                    <!-- Modal hiển thị link ảnh -->
                    <div class="text-right mb-3">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#imageDetailModal">
                            <a>Ảnh bài viết</a>
                        </button>
                    </div>

                    <div class="row">
                        <!-- Chọn danh mục -->
                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <label for="category_article_id" class="form-control-label">Danh mục bài viết</label>
                                <select name="category_article_id" id="category_article_id" class="form-control">
                                    <option value="">Vui lòng chọn</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_article_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_article_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nhập tiêu đề -->
                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <label for="title" class="form-control-label">Tiêu đề bài viết</label>
                                <input type="text" id="title" name="title" placeholder="Nhập tiêu đề"
                                    class="form-control" value="{{ old('title') }}">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Upload ảnh -->
                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <label for="image" class="form-control-label">Ảnh đại diện bài viết</label>
                                <input type="file" id="image" name="image" class="form-control">
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nội dung bài viết với CKEditor 5 -->
                        <div class="row form-group">
                            <div class="col-12 col-md-12">
                                <label for="content" class="form-control-label">Nội dung bài viết</label>
                                <textarea name="content" id="content">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <!-- Nút Submit -->
                    <div class="form-actions form-group">
                        <a href="{{ route('article.index') }}" class="btn btn-primary btn-sm">Quay lại</a>
                        <button type="submit" class="btn btn-success btn-sm">Thêm mới</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @include('admin.pages.imagearticle.show')
    {{-- <script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
    </script> --}}
@endsection
@push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                height: 300
            });
        });
    </script>
@endpush
