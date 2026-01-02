<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Form đăng ký</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($name == "" || $email == "") {
        echo "<p style='color:red'>Vui lòng nhập Họ tên và Email</p>";
    } else {
        echo "<h3>Thông tin đã gửi:</h3><ul>";
        echo "<li>Họ tên: " . htmlspecialchars($name) . "</li>";
        echo "<li>Email: " . htmlspecialchars($email) . "</li>";
        echo "<li>Giới tính: " . ($_POST["gender"] ?? "") . "</li>";
        echo "<li>Sở thích: " . implode(", ", $_POST["hobby"] ?? []) . "</li>";
        echo "</ul>";
    }
}
?>

<form method="post">
  Họ tên: <input type="text" name="name"><br><br>
  Email: <input type="email" name="email"><br><br>

  Giới tính:
  <input type="radio" name="gender" value="Nam"> Nam
  <input type="radio" name="gender" value="Nữ"> Nữ
  <br><br>

  Sở thích:
  <input type="checkbox" name="hobby[]" value="Đọc truyện"> Đọc truyện
  <input type="checkbox" name="hobby[]" value="Nghe nhạc"> Nghe nhạc
  <input type="checkbox" name="hobby[]" value="Xem phim "> Xem phim
  <input type="checkbox" name="hobby[]" value="Thể thao "> Thể thao
  <br><br>

  <button type="submit">Submit</button>
</form>

</body>
</html>
