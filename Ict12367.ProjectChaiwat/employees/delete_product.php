<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'db.php'; ?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // สร้างคำสั่ง SQL เพื่อลบข้อมูล
    $sql = "DELETE FROM products WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // ลบสำเร็จ กลับไปหน้า index
        header("Location: index.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
    }
} else {
    // ถ้าไม่มี id ส่งมา กลับไปหน้า index
    header("Location: index.php");
    exit();
}
?>
