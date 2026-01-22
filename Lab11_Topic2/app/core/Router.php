<?php
class Router {
    private $routes = [];

    // Hàm đăng ký route
    public function add($route, $callback) {
        // Chuẩn hóa: luôn bắt đầu bằng dấu /
        $route = '/' . ltrim($route, '/');
        $this->routes[$route] = $callback;
    }

    // Hàm điều hướng
    public function dispatch($currentUrl) {
        // 1. Lấy phần Path của URL (bỏ qua ?id=1...)
        $path = parse_url($currentUrl, PHP_URL_PATH);

        // 2. Lấy thư mục gốc nơi chứa index.php
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']); // Ví dụ: /Lab11/public
        $scriptDir = str_replace('\\', '/', $scriptDir); // Fix lỗi trên Windows

        // 3. Loại bỏ phần thư mục gốc khỏi URL để lấy route thực tế
        // Ví dụ: URL là /Lab11/public/employees/create -> Cắt còn /employees/create
        if ($scriptDir !== '/' && strpos($path, $scriptDir) === 0) {
            $path = substr($path, strlen($scriptDir));
        }

        // 4. Xử lý trường hợp đường dẫn rỗng hoặc chỉ có /
        $path = '/' . ltrim($path, '/');
        if ($path === '/') {
            $path = '/employees'; // Mặc định vào trang danh sách
        }

        // 5. Tìm route khớp và chạy
        if (isset($this->routes[$path])) {
            call_user_func($this->routes[$path]);
        } else {
            // Xử lý lỗi 404 (Không tìm thấy trang)
            http_response_code(404);
            echo "<div style='font-family: sans-serif; text-align:center; margin-top:50px;'>";
            echo "<h1>404 Not Found</h1>";
            echo "<p>Hệ thống không tìm thấy đường dẫn: <strong style='color:red'>" . htmlspecialchars($path) . "</strong></p>";
            echo "<p>Vui lòng kiểm tra lại Router hoặc URL.</p>";
            echo "<a href='" . url('employees') . "'>Quay về trang chủ</a>";
            echo "</div>";
        }
    }
}