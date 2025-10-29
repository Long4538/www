<?php
require_once __DIR__ . '/../model/OrderModel.php';

class OrderController {
    private $orderModel;

    public function __construct($db) {
        $this->orderModel = new OrderModel($db);
    }

    public function index() {
        $filter = $_GET['status'] ?? ''; // Nhận status từ URL nếu có
        $orders = $this->orderModel->getAllOrders($filter);
        include __DIR__ . '/../view/danhsach_donhang.php';
    }

    public function updateStatus() {
        if (isset($_GET['id']) && isset($_GET['status'])) {
            $this->orderModel->updateStatus($_GET['id'], $_GET['status']);
        }
        header("Location: index.php?act=danhsach_donhang");
        exit;
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->orderModel->deleteOrder($_GET['id']);
        }
        header("Location: index.php?act=danhsach_donhang");
        exit;
    }
}
