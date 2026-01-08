<?php
declare(strict_types=1);

/**
 * Xử lý đường dẫn file: 
 * Nếu file tồn tại trực tiếp thì dùng, 
 * nếu không sẽ tìm trong thư mục /data/ ngang hàng với /includes/
 */
function data_path(string $file): string {
    // Nếu file đã là đường dẫn tồn tại sẵn (như __DIR__ . '/students.json')
    if (file_exists($file)) {
        return $file;
    }
    
    // Ngược lại, mặc định tìm trong thư mục data/
    return __DIR__ . '/../data/' . $file;
}

function read_json(string $file, array $default = []): array {
    $path = data_path($file);
    
    if (!file_exists($path)) {
        return $default;
    }
    
    $content = file_get_contents($path);
    $data = json_decode($content, true);
    
    return is_array($data) ? $data : $default;
}

function write_json(string $file, array $data): void {
    $path = data_path($file);
    
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0777, true);
    }
    
    file_put_contents(
        $path,
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
}