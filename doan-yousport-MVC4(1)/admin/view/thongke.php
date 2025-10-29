<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">📊 Thống kê</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
            <div class="text-left">
                <p class="text-sm font-medium text-gray-500 uppercase">Tổng đơn hàng</p>
                <div class="text-3xl font-bold text-gray-800">
                    <?= $tong['tong_donhang'] ?? 0 ?>
                </div>
            </div>
            <div class="p-4 bg-blue-100 rounded-full text-blue-500">
                <i class="fas fa-file-invoice-dollar fa-lg"></i>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
            <div class="text-left">
                <p class="text-sm font-medium text-gray-500 uppercase">Tổng doanh thu</p>
                <div class="text-3xl font-bold text-gray-800">
                    <?= number_format($tong['tong_doanhthu'] ?? 0) ?> đ
                </div>
            </div>
            <div class="p-4 bg-green-100 rounded-full text-green-500">
                <i class="fas fa-dollar-sign fa-lg"></i>
            </div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between">
            <div class="text-left">
                <p class="text-sm font-medium text-gray-500 uppercase">Số danh mục</p>
                <div class="text-3xl font-bold text-gray-800">
                    <?= count($tk_danhmuc ?? []) ?>
                </div>
            </div>
            <div class="p-4 bg-yellow-100 rounded-full text-yellow-500">
                <i class="fas fa-list-alt fa-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Thống kê theo danh mục</h2>
        
        <?php if (!empty($tk_danhmuc)) : ?>
            <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                <table class="w-full whitespace-nowrap table-auto">
                    <thead class="bg-gray-50">
                        <tr class="text-left font-bold">
                            <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Danh mục</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Số sản phẩm</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Tổng doanh thu (VNĐ)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tk_danhmuc as $row) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 border-b border-gray-200 font-medium text-gray-800">
                                    <?= htmlspecialchars($row['ten_danhmuc'] ?? 'Không rõ') ?>
                                </td>
                                <td class="px-6 py-4 border-b border-gray-200">
                                    <?= $row['so_sanpham'] ?? 0 ?>
                                </td>
                                <td class="px-6 py-4 border-b border-gray-200 font-semibold text-green-600">
                                    <?= number_format($row['doanhthu'] ?? 0) ?> đ
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p>Chưa có dữ liệu thống kê.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Biểu đồ doanh thu theo danh mục</h2>
        
        <div class="relative h-96 w-full"> <canvas id="chartDoanhThu"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartDoanhThu');
    
    // Lấy dữ liệu từ PHP
    const labels = <?= json_encode(array_column($tk_danhmuc ?? [], 'ten_danhmuc')) ?>;
    const data = <?= json_encode(array_column($tk_danhmuc ?? [], 'doanhthu')) ?>;

    new Chart(ctx, {
        type: 'bar', // Biểu đồ cột
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: data,
                backgroundColor: '#4f46e5', // Màu indigo-600
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // <-- Thêm dòng này
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        // Format lại trục Y cho đẹp
                        callback: value => value.toLocaleString('vi-VN') + ' đ' 
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                }
            }
        }
    });
</script>