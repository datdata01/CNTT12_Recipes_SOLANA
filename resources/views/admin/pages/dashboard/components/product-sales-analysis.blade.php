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
            labels: @json($labels), // Dùng biến $labels từ Laravel Blade
            datasets: [{
                label: 'Số lượng bán',
                data: @json($data), // Dùng biến $data từ Laravel Blade
                backgroundColor: generateRandomColors(@json($data)
                    .length), // Tạo màu ngẫu nhiên cho từng sản phẩm
            }]
        },
        options: {
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
                        text: 'Sản phẩm'
                    }
                }
            }
        }
    });
</script>
