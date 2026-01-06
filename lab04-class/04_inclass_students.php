<?php
/**
 * Lab 04 - Xử lý chuỗi, mảng, object và render HTML
 * Input: "SV001-An-3.2;SV002-Binh-2.6;SV003-Chi-3.5"
 */

/* ======================
 * B0. Input ban đầu
 * ====================== */
$input = "SV001-An-3.2;SV002-Binh-2.6;SV003-Chi-3.5";

/* ======================
 * B1. explode(';') → tách từng bản ghi
 * ====================== */
$records = explode(';', $input);

/* ======================
 * Định nghĩa class Student
 * ====================== */
class Student {
    public string $id;
    public string $name;
    public float $gpa;

    public function __construct(string $id, string $name, float $gpa) {
        $this->id = $id;
        $this->name = $name;
        $this->gpa = $gpa;
    }

    // Xếp loại theo GPA
    public function getRank(): string {
        if ($this->gpa >= 3.2) return "Giỏi";
        if ($this->gpa >= 2.5) return "Khá";
        if ($this->gpa >= 2.0) return "Trung bình";
        return "Yếu";
    }
}

/* ======================
 * B2 + B3 + B4
 * Tách id-name-gpa, trim, ép kiểu, tạo object
 * ====================== */
$list = [];

foreach ($records as $record) {
    $parts = explode('-', $record); // B2

    if (count($parts) === 3) {
        $id   = trim($parts[0]);
        $name = trim($parts[1]);
        $gpa  = (float) trim($parts[2]); // B3

        $list[] = new Student($id, $name, $gpa); // B4
    }
}
?>
<!--html:5 ->tab -->
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>
    <style>
        table { border-collapse: collapse; width: 50%; }
        th, td { border: 1px solid #333; padding: 6px; text-align: center; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>

<h2>📋 Danh sách sinh viên</h2>

<!-- ======================
     B5. Render bảng HTML
     ====================== -->
<table>
    <tr>
        <th>Tên</th>
        <th>GPA</th>
        <th>Xếp loại</th>
    </tr>
    <?php foreach ($list as $sv): ?>
        <tr>
            <td><?= htmlspecialchars($sv->name) ?></td>
            <td><?= $sv->gpa ?></td>
            <td><?= $sv->getRank() ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- ======================
     B6. Lọc GPA >= 3.2
     ====================== -->
<h3>🏆 Sinh viên Giỏi (GPA ≥ 3.2)</h3>
<ul>
<?php
foreach ($list as $sv) {
    if ($sv->gpa >= 3.2) {
        echo "<li>" . htmlspecialchars($sv->name) . " - GPA: {$sv->gpa}</li>";
    }
}
?>
</ul>

</body>
</html>
