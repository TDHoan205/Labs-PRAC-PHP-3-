<?php
class OrderRepository {
    private $pdo;
    public function __construct($pdo) { $this->pdo = $pdo; }

    // Lấy danh sách đơn hàng (kèm tên khách)
    public function getAllOrders() {
        $sql = "SELECT o.*, c.full_name FROM orders o 
                JOIN customers c ON o.customer_id = c.id 
                ORDER BY o.order_date DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    // Lấy chi tiết 1 đơn hàng
    public function getOrderById($id) {
        $stmt = $this->pdo->prepare("SELECT o.*, c.full_name, c.email, c.phone 
                                     FROM orders o 
                                     JOIN customers c ON o.customer_id = c.id 
                                     WHERE o.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Lấy danh sách sản phẩm trong đơn hàng
    public function getOrderItems($orderId) {
        $stmt = $this->pdo->prepare("SELECT oi.*, p.name, p.sku 
                                     FROM order_items oi
                                     JOIN products p ON oi.product_id = p.id
                                     WHERE oi.order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }

    // Tiêu chí: Transaction + Tính Total trong Model + Trừ Stock
    public function createOrder($cid, $items) {
        try {
            $this->pdo->beginTransaction(); // Bắt đầu Transaction

            // 1. Tính tổng tiền (Logic nằm tại Model theo yêu cầu)
            $total = 0;
            foreach ($items as $item) {
                $total += $item['qty'] * $item['price'];
            }

            // 2. Tạo Order
            $stmt = $this->pdo->prepare("INSERT INTO orders (customer_id, order_date, total) VALUES (?, NOW(), ?)");
            $stmt->execute([$cid, $total]);
            $orderId = $this->pdo->lastInsertId();

            // 3. Thêm Items và Trừ Stock
            $stmtItem = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, qty, price) VALUES (?,?,?,?)");
            $stmtStock = $this->pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");

            foreach ($items as $item) {
                // Insert chi tiết
                $stmtItem->execute([$orderId, $item['product_id'], $item['qty'], $item['price']]);
                
                // Trừ kho (Nếu stock < qty thì rowCount = 0)
                $stmtStock->execute([$item['qty'], $item['product_id'], $item['qty']]);
                
                if ($stmtStock->rowCount() === 0) {
                    throw new Exception("Sản phẩm ID " . $item['product_id'] . " không đủ hàng tồn kho!");
                }
            }

            $this->pdo->commit(); // Thành công -> Lưu
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack(); // Lỗi -> Hoàn tác
            throw $e;
        }
    }
}