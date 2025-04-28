<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'db.php'; ?>

<?php
// ตรวจสอบว่ามีการรับ id มาหรือไม่
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

// ถ้า form ถูกส่งมา (กดบันทึก)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_code = $_POST['product_code'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE products SET 
                product_code = '$product_code',
                name = '$name',
                category = '$category',
                price = '$price',
                quantity = '$quantity'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}

// ดึงข้อมูลสินค้าเดิม
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขสินค้า</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">✏️ แก้ไขข้อมูลสินค้า</h2>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">รหัสสินค้า</label>
        <input type="text" name="product_code" class="form-control" value="<?= $product['product_code'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">ชื่อสินค้า</label>
        <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">หมวดหมู่</label>
        <input type="text" name="category" class="form-control" value="<?= $product['category'] ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">ราคา (บาท)</label>
        <input type="number" name="price" class="form-control" step="0.01" value="<?= $product['price'] ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">จำนวนคงเหลือ</label>
        <input type="number" name="quantity" class="form-control" value="<?= $product['quantity'] ?>" required>
      </div>

      <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
      <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
    </form>
  </div>
</body>
</html>
