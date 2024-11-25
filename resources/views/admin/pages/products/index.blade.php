@extends('admin.layouts.master')

@section('title')
    Danh sách sản phẩm
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Danh sách sản phẩm</strong>
        </div>

        <div class="card-body">
            <div class="text-end mb-3">
                <a class="btn btn-success" href="{{ route('products.create') }}">Thêm mới</a>
            </div>

            <!-- Bộ lọc và tìm kiếm -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="product-search" class="form-control"
                        placeholder="Tìm kiếm mã hoặc tên sản phẩm">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="status-filter">
                        <option value="all">Trạng thái</option>
                        <option value="ACTIVE">Hoạt động</option>
                        <option value="IN_ACTIVE">Vô hiệu hoá</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="category-filter">
                        <option value="all">Danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Bảng sản phẩm -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" width="1px">STT</th>
                            <th scope="col">Mã sản phẩm</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="productData">
                        <!-- Dữ liệu sản phẩm sẽ được tải động -->
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div id="pagination" class="mt-3"></div>
        </div>
    </div>
@endsection

@push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentPage = 1;

            // Hàm tải danh sách sản phẩm
            function fetchProducts(page = 1) {
                let category = $('#category-filter').val();
                let search = $('#product-search').val();
                let status = $('#status-filter').val();

                $.ajax({
                    url: `/api/admin/products/filter?page=${page}`,
                    type: 'GET',
                    data: {
                        category,
                        search,
                        status
                    },
                    success: function(response) {
                        $('#productData').empty();

                        if (response.products.length === 0) {
                            $('#productData').html(
                                '<tr><td colspan="8" class="text-center">Không tìm thấy sản phẩm nào.</td></tr>'
                            );
                            $('#pagination').html('');
                            return;
                        }

                        // Hiển thị danh sách sản phẩm
                        response.products.data.forEach(function(product, index) {
                            $('#productData').append(`
                            <tr>
                                <td>${(page - 1) * 5 + index + 1}</td>
                                <td>${product.code}</td>
                                <td>
                                    ${product.image ? `<img src="/storage/${product.image}" alt="Ảnh" width="50px">` : ''}
                                </td>
                                <td>${product.name}</td>
                                <td>
                                    ${product.product_variants.length === 1
                                        ? `${new Intl.NumberFormat('vi-VN').format(product.product_variants[0].price)} VND`
                                        : `${new Intl.NumberFormat('vi-VN').format(product.product_variants[0]?.price)} - ${new Intl.NumberFormat('vi-VN').format(product.product_variants[product.product_variants.length - 1]?.price)} VND`
                                    }
                                </td>
                                <td>
                                    ${product.status === 'ACTIVE' 
                                        ? '<span class="badge bg-primary">Hoạt động</span>' 
                                        : '<span class="badge bg-secondary">Vô hiệu hoá</span>'
                                    }
                                </td>
                                <td>${product.category_product ? product.category_product.name : 'Không có danh mục'}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="/admin/products/${product.id}/edit" class="btn btn-warning btn-sm mr-1">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                        <form action="/admin/products/${product.id}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Có chắc chắn muốn xóa không?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `);
                        });

                        // Cập nhật phân trang
                        renderPagination(response.pagination, page);
                    },
                    error: function(xhr, status, error) {
                        console.error("Có lỗi xảy ra: ", error);
                    }
                });
            }

            // Render phân trang
            function renderPagination(pagination, currentPage) {
                if (pagination.last_page <= 1) {
                    $('#pagination').html('');
                    return;
                }

                let paginationHtml = `
                <nav>
                    <ul class="pagination">
                        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                            <a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a>
                        </li>`;

                for (let i = 1; i <= pagination.last_page; i++) {
                    paginationHtml += `
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
                }

                paginationHtml += `
                        <li class="page-item ${currentPage === pagination.last_page ? 'disabled' : ''}">
                            <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                        </li>
                    </ul>
                </nav>`;

                $('#pagination').html(paginationHtml);
            }

            // Event delegation cho phân trang
            $('#pagination').on('click', '.page-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) {
                    fetchProducts(page);
                }
            });

            // Sự kiện thay đổi bộ lọc và tìm kiếm
            $('#category-filter, #status-filter').on('change', function() {
                fetchProducts(1);
            });

            $('#product-search').on('keyup', function() {
                fetchProducts(1);
            });

            // Tải danh sách sản phẩm khi trang load
            fetchProducts(currentPage);
        });
    </script>
@endpush
