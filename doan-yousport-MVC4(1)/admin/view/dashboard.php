<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">
        Dashboard - Tổng quan
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between stat-box">
            <div class="text-left">
                <p class="text-sm font-medium text-gray-500 uppercase">Tổng đơn hàng</p>
                <div class="text-3xl font-bold text-gray-800"><?= $tongquan['tong_donhang'] ?? 0 ?></div>
            </div>
            <div class="p-4 bg-red-100 rounded-full text-red-500"><i class="fas fa-shopping-cart fa-lg"></i></div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between stat-box">
            <div class="text-left">
                <p class="text-sm font-medium text-gray-500 uppercase">Tổng doanh thu</p>
                <div class="text-3xl font-bold text-gray-800"><?= number_format($tongquan['tong_doanhthu'] ?? 0) ?> đ</div>
            </div>
            <div class="p-4 bg-green-100 rounded-full text-green-500"><i class="fas fa-dollar-sign fa-lg"></i></div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between stat-box">
            <div class="text-left">
                <p class="text-sm font-medium text-gray-500 uppercase">Tổng thành viên</p>
                <div class="text-3xl font-bold text-gray-800"><?= $tongquan['tong_taikhoan'] ?? 0 ?></div>
            </div>
            <div class="p-4 bg-purple-100 rounded-full text-purple-500"><i class="fas fa-users fa-lg"></i></div>
        </div>
        <div class="bg-white shadow rounded-lg p-5 flex items-center justify-between stat-box">
            <div class="text-left">
                <p class="text-sm font-medium text-gray-500 uppercase">Tổng sản phẩm</p>
                <div class="text-3xl font-bold text-gray-800"><?= $tongquan['tong_sanpham'] ?? 0 ?></div>
            </div>
            <div class="p-4 bg-yellow-100 rounded-full text-yellow-500"><i class="fas fa-box-open fa-lg"></i></div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Tỷ lệ trạng thái đơn hàng</h2>
        <div class="relative h-64 w-full">
            <canvas id="chartDonHang"></canvas>
        </div>
        <div class="flex justify-center mt-4 space-x-4 text-sm">
            <span class="flex items-center text-yellow-600">
                <span class="w-3 h-3 bg-yellow-400 rounded-full mr-1.5"></span> Chờ xử lý
            </span>
            <span class="flex items-center text-green-600">
                <span class="w-3 h-3 bg-green-500 rounded-full mr-1.5"></span> Đã thanh toán
            </span>
            <span class="flex items-center text-red-600">
                <span class="w-3 h-3 bg-red-500 rounded-full mr-1.5"></span> Đã hủy
            </span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctxDonHang = document.getElementById('chartDonHang');
        const dataDonHang = [
            <?= $tyle_donhang['pending'] ?? $tyle_donhang['cho_xuly'] ?? 0 ?>,
            <?= $tyle_donhang['paid'] ?? $tyle_donhang['completed'] ?? $tyle_donhang['da_thanhtoan'] ?? 0 ?>,
            <?= $tyle_donhang['cancelled'] ?? $tyle_donhang['da_huy'] ?? 0 ?>
        ];
        const labelsDonHang = ['Chờ xử lý', 'Đã thanh toán', 'Đã hủy'];
        const colorsDonHang = ['#facc15', '#22c55e', '#ef4444']; // Vàng, Xanh lá, Đỏ

        new Chart(ctxDonHang, {
            type: 'doughnut',
            data: {
                labels: labelsDonHang,
                datasets: [{
                    data: dataDonHang,
                    backgroundColor: colorsDonHang,
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                cutout: '70%'
            }
        });
    </script>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">5 đơn hàng mới nhất</h2>

        <?php if (!empty($donmoi)) : ?>
            <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
                <table class="w-full whitespace-nowrap table-auto">
                    <thead class="bg-gray-50">
                        <tr class="text-left font-bold">
                            <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Mã đơn</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Khách / Tài khoản</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Tổng</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Trạng thái</th>
                            <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Ngày</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donmoi as $dh) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 border-b border-gray-200"><?= $dh['transaction_id'] ?? $dh['order_id'] ?? 'N/A' ?></td>
                                <td class="px-6 py-4 border-b border-gray-200 font-medium text-gray-800"><?= htmlspecialchars($dh['ten_khach'] ?? $dh['full_name'] ?? 'N/A') ?></td>
                                <td class="px-6 py-4 border-b border-gray-200 font-semibold text-green-600"><?= number_format($dh['tong_tien'] ?? $dh['total_amount'] ?? 0) ?> đ</td>
                                
                                <td class="px-6 py-4 border-b border-gray-200">
                                    <?php
                                    // ✅ CHỈ HIỂN THỊ 3 TRẠNG THÁI CHÍNH
                                    $status_text = 'Giao Thành Công'; // Mặc định nếu trạng thái không khớp
                                    $status_class = 'text-gray-500'; 
                                    if (isset($dh['status'])) {
                                        $status = strtolower(trim($dh['status']));
                                        
                                        if ($status == 'pending') {
                                            $status_text = 'Chờ xử lý'; 
                                            $status_class = 'text-yellow-600'; // Vàng
                                        } elseif ($status == 'paid' || $status == 'completed') { 
                                            $status_text = 'Đã thanh toán'; 
                                            $status_class = 'text-green-600'; // Xanh lá cây
                                        } elseif ($status == 'cancelled') {
                                            $status_text = 'Đã hủy'; 
                                            $status_class = 'text-red-600'; // Đỏ
                                        }
                                        // Trạng thái 'delivered' hoặc bất kỳ trạng thái nào khác sẽ hiển thị là 'Không rõ'
                                    }
                                    echo "<span class='font-medium {$status_class}'>{$status_text}</span>";
                                    ?>
                                </td>
                                                                
                                <td class="px-6 py-4 border-b border-gray-200 text-sm"><?= date('d/m/Y H:i', strtotime($dh['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p>Chưa có đơn hàng mới nào.</p>
            </div>
        <?php endif; ?>
    </div>
</div>