<div class="col-sm-12 mb-4">
    <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('monthlyRevenueChart').getContext('2d');

    // Tạo một mảng màu sắc cho mỗi tháng (12 tháng)
    var colors = [
        'rgba(255, 99, 132, 0.6)', // Màu đỏ
        'rgba(54, 162, 235, 0.6)', // Màu xanh dương
        'rgba(255, 206, 86, 0.6)', // Màu vàng
        'rgba(75, 192, 192, 0.6)', // Màu xanh lá
        'rgba(153, 102, 255, 0.6)', // Màu tím
        'rgba(255, 159, 64, 0.6)', // Màu cam
        'rgba(255, 99, 132, 0.6)', // Màu đỏ
        'rgba(54, 162, 235, 0.6)', // Màu xanh dương
        'rgba(255, 206, 86, 0.6)', // Màu vàng
        'rgba(75, 192, 192, 0.6)', // Màu xanh lá
        'rgba(153, 102, 255, 0.6)', // Màu tím
        'rgba(255, 159, 64, 0.6)' // Màu cam
    ];

    var monthlyRevenueChart = new Chart(ctx, {
        type: 'bar', // Chế độ biểu đồ cột
        data: {
            labels: @json($labelsMonthlyRevenue), // Nhãn là các tháng trong năm
            datasets: [{
                label: 'Doanh thu hàng tháng (VND)',
                data: @json($dataMonthlyRevenue), // Dữ liệu doanh thu tương ứng với mỗi tháng
                backgroundColor: colors, // Sử dụng mảng màu sắc đã tạo
                borderColor: colors.map(color => color.replace('0.6', '1')), // Tạo màu viền tương ứng
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Doanh thu (VND)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tháng'
                    }
                }
            }
        }
    });
</script>
