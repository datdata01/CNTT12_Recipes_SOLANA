@extends('admin.layouts.master')

@section('title')
    Cập nhật sản phẩm
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><strong>Cập nhật sản phẩm: </strong>{{ $product->name }}</div>
        <div class="card-body card-block">
            <form action="{{ route('products.update', $product) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <!-- Thông tin sản phẩm -->
                <div class="row">
                    <div class="col-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $product->name }}" required>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">Mã sản phẩm</label>
                            <input type="text" name="code" id="code" class="form-control"
                                value="{{ $product->code }}" required>
                            @error('code')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ $product->description }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="mb-3">
                            <label for="category_product_id" class="form-label">Danh mục sản phẩm</label>
                            <select name="category_product_id" id="category_product_id" class="form-control" required>
                                @foreach ($categoryProduct as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->category_product_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_product_id')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="ACTIVE" {{ $product->status == 'ACTIVE' ? 'selected' : '' }}>Hoạt động
                                </option>
                                <option value="IN_ACTIVE" {{ $product->status == 'IN_ACTIVE' ? 'selected' : '' }}>Ngưng
                                    hoạt động</option>
                            </select>
                            @error('status')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Ảnh sản phẩm</label>
                            <input type="file" name="image" id="image" class="form-control mb-1" accept="image/*">
                            @if ($product->image)
                                <img src="{{ '/storage/' . $product->image }}" alt="" width="100px">
                            @endif
                            @error('image')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">Album hình ảnh sản phẩm</label>
                            <input type="file" name="image_url[]" id="image_url" class="form-control" multiple
                                accept="image/*">
                            @foreach ($product->productImages as $image)
                                <img src="{{ '/storage/' . $image->image_url }}" alt="" width="70px">
                            @endforeach
                            @error('image_url')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr>

                <div class="col-12">
                    <h3>Tạo sản phẩm biến thể</h3><br>
                    <div class="d-flex">
                        <strong>Chọn thuộc tính: </strong>
                        @foreach ($attributes as $item)
                            <div class="form-check mx-2">
                                <input type="checkbox" class="form-check-input attribute-checkbox"
                                    data-id="{{ $item->id }}"
                                    {{ $product->productVariants->pluck('attributeValues.*.attribute_id')->flatten()->unique()->contains($item->id)? 'checked': '' }}>
                                <label class="form-check-label">{{ $item->name }}</label>
                            </div>
                        @endforeach
                    </div><br>
                    <div class="d-flex">
                        <button type="button" id="add-variant" class="btn btn-secondary btn-sm mx-1">Tạo thủ công</button>
                        <button type="button" id="check-duplicates" class="btn btn-warning btn-sm">Check Trùng Lặp</button>
                    </div>
                    <hr>

                    <!-- Vùng hiển thị các biến thể được tạo -->
                    <div id="variants"></div>
                </div>


                <!-- Biến thể hiện có -->
                <div id="existing-variants" class="col-12">
                    @foreach ($product->productVariants as $index => $variant)
                        <div class="variant mb-4 border p-3">
                            <h4>Biến thể {{ $index + 1 }}</h4><br>

                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex flex-wrap">
                                    <strong class="mr-3">Thuộc tính:</strong>
                                    @foreach ($variant->attributeValues as $attributeValue)
                                        <div class="form-group d-flex align-items-center me-2">
                                            <select
                                                name="variants[{{ $variant->id }}][attributes][{{ $attributeValue->attribute_id }}]"
                                                class="form-control variant-select"
                                                data-attribute-id="{{ $attributeValue->attribute_id }}" required>
                                                <option value="">Chọn {{ $attributeValue->attribute->name }}
                                                </option>
                                                @foreach ($attributeValue->attribute->attributeValues as $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == $attributeValue->id ? 'selected' : '' }}>
                                                        {{ $value->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach

                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-info btn-sm toggle-variant-info">Ẩn/Hiện thông
                                        tin</button>
                                    <button type="button" class="btn btn-danger btn-sm remove-variant"
                                        data-variant-id="{{ $variant->id }}">Xóa biến thể</button>
                                </div>
                            </div>

                            <!-- Thông tin chi tiết biến thể (ẩn/hiện) -->
                            <div class="variant-info mt-3" style="display:none;">
                                <div class="form-group mb-2">
                                    <label>Giá:</label>
                                    <input type="number" name="variants[{{ $variant->id }}][price]"
                                        class="form-control" value="{{ $variant->price }}" required min="0">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Số lượng:</label>
                                    <input type="number" name="variants[{{ $variant->id }}][quantity]"
                                        class="form-control" value="{{ $variant->quantity }}" required min="0">
                                </div>
                                <input type="hidden" name="variants[{{ $variant->id }}][id]"
                                    value="{{ $variant->id }}">
                                <input type="hidden" class="existing-variant-attributes"
                                    value="{{ $variant->attributeValues->pluck('id')->implode('-') }}">
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="mt-3">
                    <a class="btn btn-primary" href="{{ route('products.index') }}">Quay lại</a>
                    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#description').summernote({
                height: 300,
            });

            // Ẩn/hiện phần thông tin chi tiết của từng biến thể
            document.querySelectorAll('.toggle-variant-info').forEach(button => {
                button.addEventListener('click', function() {
                    const variantInfo = this.closest('.variant').querySelector('.variant-info');
                    variantInfo.style.display = variantInfo.style.display === 'none' ? 'block' :
                        'none';
                });
            });

            // Xoá biến thể
            $(document).on('click', '.remove-variant', function() {
                const variantId = $(this).data('variant-id');
                $(this).closest('.variant').hide();
                $('<input>').attr({
                    type: 'hidden',
                    name: 'delete_variants[]',
                    value: variantId
                }).appendTo('form');
            });

            let variantCount = $('#variants .variant').length; // Đếm số biến thể ban đầu


            // Khởi tạo selectedAttributes từ các thuộc tính đã chọn
            const selectedAttributes = new Set();

            // Duyệt qua tất cả các checkbox thuộc tính và thêm các thuộc tính đã được chọn vào selectedAttributes
            $('.attribute-checkbox').each(function() {
                if ($(this).is(':checked')) {
                    selectedAttributes.add(parseInt($(this).data('id')));
                }
            });

            // Khi người dùng chọn hoặc bỏ chọn checkbox thuộc tính
            $('.attribute-checkbox').on('change', function() {
                const attributeId = parseInt($(this).data('id'));

                if ($(this).is(':checked')) {
                    selectedAttributes.add(attributeId);
                } else {
                    selectedAttributes.delete(attributeId);
                }
            });

            // Hàm thêm biến thể
            function addVariant(index = $('.variant').length, attributes = []) {
                const variantDiv = $(`
                    <div class="variant mb-4 border p-3">
                        <h4>Biến thể ${index + 1}</h4><br>
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-wrap">
                                <strong class="mr-3">Thuộc tính:</strong>
                                ${generateAttributeSelects(index, attributes)}
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-info btn-sm toggle-variant-info">Ẩn/Hiện thông tin</button>
                                <button type="button" class="btn btn-danger btn-sm remove-variant">Xóa biến thể</button>
                            </div>
                        </div>
                        <div class="variant-info" style="display:none;">
                            <div class="form-group">
                                <label>Giá:</label>
                                <input type="number" name="variants[${index}][price]" class="form-control" required min="0">
                            </div>
                            <div class="form-group">
                                <label>Số lượng:</label>
                                <input type="number" name="variants[${index}][quantity]" class="form-control" required min="0">
                            </div>
                        </div>
                    </div>
                `);

                // Lắng nghe sự kiện cho nút ẩn hiện
                variantDiv.find('.toggle-variant-info').on('click', function() {
                    $(this).closest('.variant').find('.variant-info').toggle();
                });

                return variantDiv;
            }

            // Hàm tạo các phần tử chọn thuộc tính dựa trên thuộc tính đã chọn
            function generateAttributeSelects(index, attributes) {
                let attributeSelects = '';
                @foreach ($attributes as $attribute)
                    // Kiểm tra nếu thuộc tính nằm trong danh sách đã chọn
                    if (selectedAttributes.has(parseInt('{{ $attribute->id }}'))) {
                        attributeSelects += `
                <div class="form-group d-flex align-items-center me-1">
                    <select name="variants[${index}][attributes][{{ $attribute->id }}]"
                        class="form-control variant-select" data-attribute-id="{{ $attribute->id }}" required>
                        <option value="">Chọn {{ $attribute->name }}</option>
                        @foreach ($attribute->attributeValues as $value)
                            <option value="{{ $value->id }}" ${attributes.includes('{{ $value->id }}') ? 'selected' : ''}>{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            `;
                    }
                @endforeach
                return attributeSelects;
            }

            // Xử lý sự kiện cho nút "Thêm biến thể"
            $('#add-variant').on('click', function() {
                const newVariant = addVariant();
                $('#variants').append(newVariant);
            });

            $('#check-duplicates').on('click', function() {
                const variants = []; // Mảng lưu trữ các biến thể để kiểm tra trùng lặp
                const duplicateVariants = []; // Mảng lưu trữ thông tin các biến thể trùng lặp

                // Duyệt qua tất cả các biến thể
                $('.variant').each(function(index) {
                    const attributes = [];

                    // Duyệt qua tất cả các thuộc tính của biến thể
                    $(this).find('.variant-select').each(function() {
                        const attributeId = $(this).data('attribute-id');
                        const valueId = $(this).val();
                        attributes.push({
                            attributeId,
                            valueId
                        });
                    });

                    // Chuỗi JSON của tổ hợp thuộc tính cho biến thể
                    const attributesString = JSON.stringify(attributes);

                    // Kiểm tra nếu biến thể đã tồn tại trong mảng
                    const duplicateIndex = variants.indexOf(attributesString);
                    if (duplicateIndex !== -1) {
                        // Nếu trùng lặp, lưu lại thông tin biến thể bị trùng
                        duplicateVariants.push({
                            current: index + 1, // Vị trí của biến thể hiện tại
                            duplicateWith: duplicateIndex + 1 // Vị trí của biến thể trùng
                        });
                    } else {
                        // Nếu không trùng lặp, thêm tổ hợp thuộc tính vào mảng
                        variants.push(attributesString);
                    }
                });

                // Hiển thị thông báo
                if (duplicateVariants.length > 0) {
                    alert('Có biến thể bị trùng lặp');
                } else {
                    alert('Không có biến thể nào bị trùng lặp.');
                }
            });
        });
    </script>
@endpush
