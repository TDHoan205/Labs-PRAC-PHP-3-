<?php
require_once 'includes/auth.php';
require_once 'includes/data.php';
require_login();

// Lấy thông tin sinh viên từ session
$sv = $_SESSION['student'] ?? $_SESSION['user'] ?? [];
$fullName = $sv['full_name'] ?? $sv['username'] ?? 'Sinh viên';

include 'includes/header.php';
?>

<div class="center-box" style="min-height: 80vh;">
    <div class="login-box" style="width: 100%; max-width: 600px;">
        
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="font-size: 2rem;">🎓 Student Dashboard</h1>
            <p>Xin chào, <strong><?= htmlspecialchars($fullName) ?></strong>!</p>
        </div>

        <div class="dashboard-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            
            <a href="student/profile.php" class="card-link" style="text-decoration: none; color: inherit;">
                <div class="card" style="padding: 20px; text-align: center; border: 1px solid #ddd; border-radius: 8px; transition: 0.3s;">
                    <span style="font-size: 2rem;">👤</span>
                    <h3>Hồ sơ</h3>
                    <p style="font-size: 0.8rem; color: #666;">Thông tin cá nhân</p>
                </div>
            </a>

            <a href="student/courses.php" class="card-link" style="text-decoration: none; color: inherit;">
                <div class="card" style="padding: 20px; text-align: center; border: 1px solid #ddd; border-radius: 8px; transition: 0.3s;">
                    <span style="font-size: 2rem;">📚</span>
                    <h3>Học phần</h3>
                    <p style="font-size: 0.8rem; color: #666;">Đăng ký môn học</p>
                </div>
            </a>

            <a href="student/registrations.php" class="card-link" style="text-decoration: none; color: inherit;">
                <div class="card" style="padding: 20px; text-align: center; border: 1px solid #ddd; border-radius: 8px; transition: 0.3s;">
                    <span style="font-size: 2rem;">📝</span>
                    <h3>Đã đăng ký</h3>
                    <p style="font-size: 0.8rem; color: #666;">Quản lý đăng ký</p>
                </div>
            </a>

            <a href="student/grades.php" class="card-link" style="text-decoration: none; color: inherit;">
                <div class="card" style="padding: 20px; text-align: center; border: 1px solid #ddd; border-radius: 8px; transition: 0.3s;">
                    <span style="font-size: 2rem;">📊</span>
                    <h3>Kết quả</h3>
                    <p style="font-size: 0.8rem; color: #666;">Xem bảng điểm</p>
                </div>
            </a>

        </div>

        <div style="margin-top: 30px; text-align: center;">
            <form method="post" action="logout.php">
                <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                <button type="submit" style="background-color: #e74c3c; width: auto; padding: 10px 30px;">🚪 Đăng xuất</button>
            </form>
        </div>

    </div>
</div>

<style>
    /* Hiệu ứng hover cho các thẻ card trên Dashboard */
    .card:hover {
        background-color: #f8f9fa;
        transform: translateY(-5px);
        border-color: #3498db !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card-link:hover h3 {
        color: #3498db;
    }
</style>

<?php include 'includes/footer.php'; ?>