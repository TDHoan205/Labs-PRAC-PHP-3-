<?php
class Logger {
    public static function log($message) {
        // File log nằm trong thư mục storage/logs
        $logFile = __DIR__ . '/../../storage/logs/app.log';
        
        // Nếu thư mục chưa có thì tạo mới
        if (!is_dir(dirname($logFile))) {
            mkdir(dirname($logFile), 0777, true);
        }

        $time = date('Y-m-d H:i:s');
        // Ghi nối tiếp vào file
        file_put_contents($logFile, "[$time] $message" . PHP_EOL, FILE_APPEND);
    }
}