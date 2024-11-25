@extends('admin.layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <strong class="card-title">Danh sách đơn hàng</strong>
        </div>

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-9">
                    <input type="text" id="order-search" class="form-control col-6" placeholder="Tìm kiếm mã đơn hàng hoặc tên người dùng">
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="order-status-filter">
                        <option value="all">Chọn tất cả</option>
                        <option value="PENDING">Đang chờ xử lý</option>
                        <option value="DELIVERING">Đang giao hàng</option>
                        <option value="SHIPPED">Đã giao hàng</option>
                        <option value="COMPLETED">Đơn hàng hoàn tất</option>
                        <option value="CANCELED">Đơn hàng đã Huỷ</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Người dùng</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Phương thức thanh toán</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Ngày đặt</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="orderData">
                        <!-- Nội dung đơn hàng sẽ được tải động -->
                    </tbody>
                </table>
                <div id="pagination" class="mt-3">
                    <!-- Phân trang sẽ được tải động -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('admin-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentPage = 1;

        // Hàm tải dữ liệu đơn hàng
        function fetchOrders(page = 1) {
            let status = $('#order-status-filter').val();
            let search = $('#order-search').val();

            $.ajax({
                url: `/api/admin/orders/filter?page=${page}`,
                type: 'GET',
                data: {
                    status: status,
                    search: search
                },
                success: function(response) {
                    $('#orderData').empty();
                    response.orders.data.forEach(function(order) {
                        $('#orderData').append(`
                            <tr>
                                <td>${order.code}</td>
                                <td>${order.user.full_name}</td>
                                <td>${new Intl.NumberFormat('vi-VN').format(order.total_amount)} VND</td>
                                <td>${order.payment_method === 'CASH' ? '<span class="badge bg-info">Thanh toán khi nhận hàng</span>' : '<span class="badge bg-info">Thanh toán Online</span>'}</td>
                                <td>${order.status === 'PENDING' ? '<span class="badge bg-warning">Đang chờ xử lý</span>' :
                                        order.status === 'DELIVERING' ? '<span class="badge bg-primary">Đang giao hàng</span>' :
                                        order.status === 'SHIPPED' ? '<span class="badge bg-primary">Đã giao hàng</span>' :
                                        order.status === 'COMPLETED' ? '<span class="badge bg-success">Đơn hàng hoàn tất</span>' :
                                        '<span class="badge bg-danger">Đơn hàng đã Huỷ</span>'}
                                </td>
                                <td>${new Date(order.created_at).toLocaleDateString('vi-VN')}</td>
                                <td><a href="/admin/orders/${order.id}/edit" class="btn btn-primary btn-sm">Cập nhật trạng thái</a></td>
                            </tr>
                        `);
                    });

                    // Cập nhật phân trang
                    $('#pagination').html(`
                        <div class="pagination">
                            <div class="page-item ${page === 1 ? 'disabled' : ''}">
                                <span class="page-link" onclick="fetchOrders(${page - 1})">&lt;</span>
                            </div>
                            ${Array.from({ length: response.orders.last_page }, (_, i) => `
                                <div class="page-item ${page === i + 1 ? 'active' : ''}">
                                    <span class="page-link" onclick="fetchOrders(${i + 1})">${i + 1}</span>
                                </div>
                            `).join('')}
                            <div class="page-item ${page === response.orders.last_page ? 'disabled' : ''}">
                                <span class="page-link" onclick="fetchOrders(${page + 1})">&gt;</span>
                            </div>
                        </div>
                    `);

                    currentPage = page;
                },
                error: function(xhr, status, error) {
                    console.error("Có lỗi xảy ra: ", error);
                }
            });
        }

        // Lắng nghe sự kiện thay đổi bộ lọc và tìm kiếm
        $('#order-status-filter').on('change', function() {
            currentPage = 1;
            fetchOrders(currentPage);
        });

        $('#order-search').on('keyup', function() {
            currentPage = 1;
            fetchOrders(currentPage);
        });

        // Gọi hàm tải dữ liệu đơn hàng khi tải trang
        $(document).ready(function() {
            fetchOrders(currentPage);
        });
    </script>
@endpush
