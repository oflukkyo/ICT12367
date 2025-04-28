<?php
// db.php - เชื่อมต่อฐานข้อมูล

$host = 'localhost';     // Host ที่เรารัน XAMPP
$user = 'root';          // User ค่าเริ่มต้นของ XAMPP
$pass = '';              // Password (ปกติจะว่าง)
$dbname = 'inventory_db'; // ชื่อฐานข้อมูลที่เราสร้าง

$conn = new mysqli($host, $user, $pass, $dbname);

// เช็คการเชื่อมต่อ
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>
