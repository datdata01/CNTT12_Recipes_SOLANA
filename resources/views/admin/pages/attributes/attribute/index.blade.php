@extends('admin.layouts.master')
@section('title')
Trang này để thử cho ae nhé :)))
@endsection
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><strong>Thêm thuộc tính</strong></div>
            <div class="card-body card-block">
                <div class="row form-group">
                    <div class="col">
                        <form action="{{ route('attributes.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Tên thuộc tính" value="{{ old('name') }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">Thêm </button>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Danh sách thuộc tính</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attribute as $index => $list)
                        <tr>
                            <td>{{ $index +1 }}</td>
                            <td>{{ $list->name }}</td>
                            <td>
                                <a href="{{ route('attributes.edit', $list->id) }}">
                                    <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                                    <form action="{{ route('attributes.destroy', $list->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa?')"><i
                                                class="fa fa-trash-o"></i></button>
                                    </form>
                                </a>

                            </td>

                        </tr>

                        @endforeach
                    </tbody>
                </table>
                {{$attribute->links()}}
            </div>
        </div>
    </div>
</div>

@endsection