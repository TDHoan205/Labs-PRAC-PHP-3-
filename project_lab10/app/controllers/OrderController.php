<?php
require_once __DIR__ . '/../models/ProductRepository.php';
require_once __DIR__ . '/../models/CustomerRepository.php';
require_once __DIR__ . '/../models/OrderRepository.php';

class OrderController {
    private $pRepo, $cRepo, $oRepo;
    public function __construct($pdo) {
        $this->pRepo = new ProductRepository($pdo);
        $this->cRepo = new CustomerRepository($pdo);
        $this->oRepo = new OrderRepository($pdo);
    }

    // Tiêu chí: Danh sách đơn hàng
    public function index() {
        $orders = $this->oRepo->getAllOrders();
        require __DIR__ . '/../views/orders/index.php';
    }

    // Tiêu chí: Xem chi tiết đơn hàng (Show)
    public function show() {
        $id = $_GET['id'];
        $order = $this->oRepo->getOrderById($id);
        $items = $this->oRepo->getOrderItems($id);
        require __DIR__ . '/../views/orders/show.php';
    }

    public function create() {
        $customers = $this->cRepo->getAll();
        $products = $this->pRepo->getAll();
        require __DIR__ . '/../views/orders/create.php';
    }

    public function store() {
        $cid = $_POST['customer_id'];
        $items = [];
        
        // Lọc sản phẩm được chọn
        if (isset($_POST['product_ids'])) {
            foreach ($_POST['product_ids'] as $pid => $val) {
                $qty = (int)$_POST['qtys'][$pid];
                // Tiêu chí: Validate Qty > 0
                if ($qty > 0) {
                    $prod = $this->pRepo->getById($pid);
                    $items[] = ['product_id' => $pid, 'qty' => $qty, 'price' => $prod['price']];
                }
            }
        }

        if (empty($items)) {
            $error = "Vui lòng chọn ít nhất 1 sản phẩm với số lượng > 0";
            $this->create(); 
            return;
        }

        try {
            $id = $this->oRepo->createOrder($cid, $items);
            header("Location: index.php?c=orders&a=success&id=$id");
        } catch (Exception $e) {
            $error = "Giao dịch thất bại: " . $e->getMessage(); // Báo lỗi trừ kho ở đây
            $this->create();
        }
    }
    public function success() { require __DIR__ . '/../views/orders/success.php'; }
}