@extends('admin.layouts.master')
@section('title')

@endsection
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><strong>Thêm Thuộc tính</strong></div>
            <div class="card-body card-block">
                <div class="row form-group">
                    <div class="col">
                        <form action="{{ route('attributeValues.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                {{-- <label for="name">Thuộc Tính</label> --}}
                                <select class="form-control" name="attribute_id">
                                    <option value="" disabled selected>Chọn loại thuộc tính</option>
                                    @foreach ($listAttributes as $attribute)
                                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                    @endforeach
                                </select>
                                @error('attribute_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" name="name" class="form-control" placeholder="Tên giá thuộc tính">
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
                <strong class="card-title">Giá trị thuộc tính</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Thuộc tính</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listAttributeValues as $index => $value)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $value->attribute->name }}</td>
                            <td>{{ $value->name }}</td>

                            <td>
                                <a href="{{ route('attributeValues.edit', $value->id) }}">
                                    <button class="btn btn-warning"><i class="fa fa-pencil"></i></button>
                                    <form action="{{ route('attributeValues.destroy', $value->id) }}" method="POST"
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
                {{ $listAttributeValues->links() }}
            </div>
        </div>

    </div>

    @endsection