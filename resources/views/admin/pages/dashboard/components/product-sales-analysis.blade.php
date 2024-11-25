<div class="col-sm-12 mb-4">
    <canvas id="salesChart" width="400" height="200"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx1 = document.getElementById('salesChart').getContext('2d');

    // Hàm tạo màu ngẫu nhiên
    function generateRandomColors(numColors) {
        const colors = [];
        for (let i = 0; i < numColors; i++) {
            const color =
                `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.6)`;
            colors.push(color);
        }
        return colors;
    }

    var salesChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: @json($codes), // Hiển thị mã sản phẩm dưới trục X
            datasets: [{
                label: 'Số lượng bán',
                data: @json($data), // Số lượng bán
                backgroundColor: generateRandomColors(@json($data).length),
            }]
        },
        options: {
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            // Hiển thị số lượng và tên sản phẩm khi hover
                            const names = @json($labels); // Truyền tên sản phẩm từ Blade
                            const sold = context.raw; // Số lượng bán
                            const index = context.dataIndex; // Lấy vị trí của cột
                            return `${names[index]}, Số lượng bán: ${sold}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Số lượng'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mã sản phẩm (Top 10)'
                    }
                }
            }
        }
    });
</script>
