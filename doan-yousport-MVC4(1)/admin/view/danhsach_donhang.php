<div class="bg-white shadow rounded-lg p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">🧾 Danh sách đơn hàng</h1>

    <form method="GET" action="index.php" class="mb-6 flex items-center space-x-3">
        <input type="hidden" name="act" value="danhsach_donhang">
        <label for="status_filter" class="font-medium text-gray-700">Lọc trạng thái:</label>
        <select name="status" id="status_filter" onchange="this.form.submit()"
                class="shadow-sm border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
            <option value="" <?= empty($_GET['status']) ? 'selected' : '' ?>>Tất cả</option>
            <option value="pending" <?= ($_GET['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Chờ xử lý</option>
            <option value="paid" <?= ($_GET['status'] ?? '') == 'paid' ? 'selected' : '' ?>>Đã thanh toán</option>
            <option value="cancelled" <?= ($_GET['status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
            <option value="delivered" <?= ($_GET['status'] ?? '') == 'delivered' ? 'selected' : '' ?>>Đã giao</option> 
        </select>
    </form>

    <?php 
    // Hiển thị thông báo (nếu có từ redirect)
    if (isset($_GET['update_success'])) echo '<div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">Đã cập nhật trạng thái đơn hàng.</div>';
    if (isset($_GET['delete_success'])) echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">Đã xóa đơn hàng.</div>';
    ?>

    <?php if (!empty($orders)) : ?>
        <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative">
            <table class="w-full whitespace-nowrap table-auto">
                <thead class="bg-gray-50">
                    <tr class="text-left font-bold">
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">ID</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Khách hàng</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Email / SĐT</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Địa chỉ</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Tổng tiền</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Trạng thái</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600">Ngày đặt</th>
                        <th class="px-6 py-3 border-b-2 border-gray-200 text-gray-600 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b border-gray-200"><?= $order['transaction_id'] ?></td>
                            <td class="px-6 py-4 border-b border-gray-200 font-medium text-gray-800"><?= htmlspecialchars($order['customer_name'] ?? $order['full_name'] ?? 'N/A') ?></td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                <?= htmlspecialchars($order['email']) ?><br>
                                <?= htmlspecialchars($order['phone']) ?>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm" style="min-width: 200px; white-space: normal;">
                                <?= htmlspecialchars($order['address']) ?>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 font-semibold text-green-600"><?= number_format($order['total_amount']) ?>đ</td>
                            <td class="px-6 py-4 border-b border-gray-200">
                               <?php 

                                $status = strtolower($order['status']);
                                $status_class = 'bg-gray-100 text-gray-600'; // Mặc định
                                $status_text = ucfirst($status); 
                                if ($status == 'pending') {
                                    $status_class = 'bg-yellow-100 text-yellow-700'; $status_text = 'Chờ xử lý';
                                } elseif ($status == 'paid') { // <-- ĐÃ SỬA
                                    $status_class = 'bg-green-100 text-green-700'; $status_text = 'Đã thanh toán';
                                } elseif ($status == 'delivered') {
                                    $status_class = 'bg-green-100 text-green-700'; $status_text = 'Đã giao'; 
                                } elseif ($status == 'cancelled') {
                                    $status_class = 'bg-red-100 text-red-700'; $status_text = 'Đã hủy';
                                }
                                ?>
                                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full <?= $status_class ?>">
                                    <?= $status_text ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 border-b border-gray-200 text-right space-x-2">
                                <?php if($order['status'] == 'pending'): ?>
                                    <a href="index.php?act=danhsach_donhang&action=update&id=<?= $order['transaction_id'] ?>&status=paid&current_status=<?= $status_filter ?? '' ?>" 
                                       onclick="return confirm('Xác nhận đơn hàng này đã thanh toán?');"
                                       class="px-2 py-1 bg-green-500 text-white rounded text-xs font-medium hover:bg-green-600" title="Xác nhận thanh toán">
                                       <i class="fas fa-check"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if($order['status'] == 'paid'): ?>
                                     <a href="index.php?act=danhsach_donhang&action=update&id=<?= $order['transaction_id'] ?>&status=delivered&current_status=<?= $status_filter ?? '' ?>" 
                                       onclick="return confirm('Xác nhận đơn hàng này đã giao thành công?');"
                                       class="px-2 py-1 bg-blue-500 text-white rounded text-xs font-medium hover:bg-blue-600" title="Đánh dấu đã giao">
                                       <i class="fas fa-truck"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if($order['status'] == 'pending' || $order['status'] == 'paid'): ?>
                                    <a href="index.php?act=danhsach_donhang&action=update&id=<?= $order['transaction_id'] ?>&status=cancelled&current_status=<?= $status_filter ?? '' ?>" 
                                       onclick="return confirm('Bạn có chắc muốn HỦY đơn hàng này?');"
                                       class="px-2 py-1 bg-yellow-500 text-white rounded text-xs font-medium hover:bg-yellow-600" title="Hủy đơn hàng">
                                       <i class="fas fa-ban"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="index.php?act=danhsach_donhang&action=delete&id=<?= $order['transaction_id'] ?>&current_status=<?= $status_filter ?? '' ?>" 
                                   onclick="return confirm('Bạn có chắc chắn muốn XÓA đơn hàng này?');"
                                   class="px-2 py-1 bg-red-500 text-white rounded text-xs font-medium hover:bg-red-600" title="Xóa đơn hàng">
                                   <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p>Không có đơn hàng nào khớp với bộ lọc.</p>
        </div>
    <?php endif; ?>
</div>