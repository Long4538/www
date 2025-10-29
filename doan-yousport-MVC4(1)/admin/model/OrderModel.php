<?php
class OrderModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllOrders($filter = '') {
        $sql = "SELECT 
                    t.transaction_id,
                    u.full_name AS username,  -- Lấy full_name và đặt tên là username
                    u.email,
                    t.address,
                    t.phone,
                    t.status,
                    t.payment_method,
                    t.created_at,
                    SUM(o.quantity) AS total_products,
                    t.total_amount
                FROM transactions t
                LEFT JOIN users u ON t.user_id = u.user_id
                LEFT JOIN orders o ON t.transaction_id = o.transaction_id";

        if ($filter != '') {
            $sql .= " WHERE t.status = :status";
        }

        $sql .= " GROUP BY t.transaction_id ORDER BY t.transaction_id DESC";

        $stmt = $this->db->prepare($sql);

        if ($filter != '') {
            $stmt->execute(['status' => $filter]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE transactions SET status = :status WHERE transaction_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function deleteOrder($id) {
        $this->db->prepare("DELETE FROM orders WHERE transaction_id = :id")->execute(['id' => $id]);
        return $this->db->prepare("DELETE FROM transactions WHERE transaction_id = :id")->execute(['id' => $id]);
    }
}
