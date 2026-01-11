<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký thành viên</title>
    <style> 
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 100px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="number"], textarea {
            padding: 5px; width: 300px;
        }
    </style>
</head>
<body>

    <h2>Form Đăng Ký</h2>
    
    <form action="result.php" method="POST">
        
        <div class="form-group">
            <label>Họ tên:</label>
            <input type="text" name="full_name" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Tuổi:</label>
            <input type="number" name="age" required>
        </div>

        <div class="form-group">
            <label>Giới tính:</label>
            <input type="radio" name="gender" value="Nam" checked> Nam
            <input type="radio" name="gender" value="Nữ"> Nữ
        </div>

        <div class="form-group">
            <label>Sở thích:</label>
            <input type="checkbox" name="hobbies[]" value="Đọc sách"> Đọc sách
            <input type="checkbox" name="hobbies[]" value="Du lịch"> Du lịch
            <input type="checkbox" name="hobbies[]" value="Thể thao"> Thể thao
        </div>

        <div class="form-group">
            <label>Ghi chú:</label>
            <textarea name="notes" rows="4"></textarea>
        </div>

        <button type="submit">Gửi thông tin</button>
    </form>

</body>
</html>