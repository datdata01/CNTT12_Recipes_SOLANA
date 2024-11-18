@extends('admin.layouts.master')
@section('title')
    Danh sách hình ảnh
@endsection
@section('content')
    <div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Danh sách hình ảnh bài viết</strong>
                </div>
                <div class="card-body">
                    <table style="table-layout: fixed; width: 100%;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" width="10px">#</th>
                                <th scope="col" width="60px">Hình ảnh bài viết</th>
                                <th scope="col" width="60px">Link ảnh bài viết</th>
                                <th scope="col" width="10px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listImageArticle as $index => $listimage)
                                <tr>
                                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $listimage->image_url) }}" alt="image"
                                            width="100px" height="100px">
                                    </td>
                                    <td class="text-center">
                                        <span style="cursor: pointer; color: rgb(0, 0, 0); text-decoration: underline;"
                                            onclick="copyToClipboard('{{ asset('storage/' . $listimage->image_url) }}')">
                                            {{ asset('storage/' . $listimage->image_url) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('imagearticle.destroy', $listimage->id) }}" method="POST"
                                            style="display:inline;" id="delete-form-{{ $listimage->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa hình ảnh bài viết này không?') ? document.getElementById('delete-form-{{ $listimage->id }}').submit() : false;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $listImageArticle->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Copy link thành công');
            }, function(err) {
                console.error('Lỗi khi copy link: ', err);
            });
        }
    </script>
@endsection
