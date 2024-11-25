@extends('admin.layouts.master')

@section('title')
    Danh sách người dùng
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Danh sách người dùng</strong>
        </div>

        <div class="card-body">
            <div class="text-end mb-3">
                <a class="btn btn-success" href="{{ route('users.create') }}">Thêm mới</a>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="user-search" class="form-control"
                        placeholder="Tìm kiếm tên hoặc email người dùng">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="status-filter">
                        <option value="all">Trạng thái</option>
                        <option value="ACTIVE">Hoạt động</option>
                        <option value="IN_ACTIVE">Vô hiệu hoá</option>
                    </select>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">Ảnh đại diện</th>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Vai trò</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <!-- Dữ liệu người dùng sẽ được tải động -->
                </tbody>
            </table>

            <div id="pagination"></div>
        </div>
    </div>

    @push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentPage = 1;

            // Hàm tải danh sách người dùng
            function fetchUsers(page = 1) {
                let search = $('#user-search').val();
                let status = $('#status-filter').val();

                $.ajax({
                    url: `/api/admin/users/filter?page=${page}`,
                    type: 'GET',
                    data: {
                        search,
                        status
                    },
                    success: function(response) {
                        $('#userData').empty();

                        if (response.users.data.length === 0) {
                            $('#userData').html(
                                '<tr><td colspan="7" class="text-center">Không tìm thấy người dùng nào.</td></tr>'
                            );
                            $('#pagination').html('');
                            return;
                        }

                        // Hiển thị danh sách người dùng
                        response.users.data.forEach(function(user, index) {
                            $('#userData').append(`
                                <tr>
                                    <td>${(page - 1) * 5 + index + 1}</td>
                                    <td>${user.avatar ? `<img src="/storage/${user.avatar}" alt="Ảnh" width="50px">` : ''}</td>
                                    <td>${user.full_name}</td>
                                    <td>${user.email}</td>
                                    <td>
                                        ${user.status === 'ACTIVE' 
                                            ? '<span class="badge bg-primary">Hoạt động</span>' 
                                            : '<span class="badge bg-secondary">Vô hiệu hoá</span>'
                                        }
                                    </td>
                                    <td>
                                        ${user.roles && user.roles.length > 0
                                            ? user.roles.map(role => {
                                                // Dựa vào tên vai trò, áp dụng màu sắc khác nhau
                                                let roleClass = '';
                                                switch (role.name) {
                                                    case 'Admin':
                                                        roleClass = 'bg-danger';  // Màu đỏ
                                                        break;
                                                    case 'User':
                                                        roleClass = 'bg-primary';  // Màu xanh dương
                                                        break;
                                                    default:
                                                        roleClass = 'bg-secondary';  // Màu xám
                                                }
                                                return `<span class="badge ${roleClass}">${role.name}</span>`;
                                            }).join(' ')  // Nối tất cả các vai trò với dấu cách
                                            : 'Chưa xác định'
                                        }
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="/admin/users/${user.id}/edit" class="btn btn-warning btn-sm mr-1">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            <form action="/admin/users/${user.id}" method="POST">
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
                            </li>
                `;

                for (let i = 1; i <= pagination.last_page; i++) {
                    paginationHtml += `
                        <li class="page-item ${currentPage === i ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `;
                }

                paginationHtml += `
                        <li class="page-item ${currentPage === pagination.last_page ? 'disabled' : ''}">
                            <a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
                `;

                $('#pagination').html(paginationHtml);
            }

            // Event delegation cho phân trang
            $('#pagination').on('click', '.page-link', function(e) {
                e.preventDefault();
                const page = $(this).data('page');
                if (page) {
                    fetchUsers(page);
                }
            });

            // Sự kiện thay đổi bộ lọc và tìm kiếm
            $('#status-filter').on('change', function() {
                fetchUsers(1);
            });

            $('#user-search').on('keyup', function() {
                fetchUsers(1);
            });

            // Tải danh sách người dùng khi trang load
            fetchUsers(currentPage);
        });
    </script>
@endpush
@endsection
