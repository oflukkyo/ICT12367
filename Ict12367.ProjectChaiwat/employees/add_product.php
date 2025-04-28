<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
?>

<?php include 'db.php'; ?>

<?php
// เช็กว่ามีการส่งฟอร์มหรือยัง
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_code = $_POST['product_code'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // สร้างคำสั่ง SQL เพื่อเพิ่มสินค้า
    $sql = "INSERT INTO products (product_code, name, category, price, quantity) 
            VALUES ('$product_code', '$name', '$category', '$price', '$quantity')";

    if ($conn->query($sql) === TRUE) {
        // ถ้าเพิ่มสำเร็จ กลับไปหน้า index.php
        header("Location: index.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>เพิ่มสินค้าใหม่</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">➕ เพิ่มสินค้าใหม่</h2>

    <form method="POST" action="add_product.php">
      <div class="mb-3">
        <label class="form-label">รหัสสินค้า</label>
        <input type="text" name="product_code" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">ชื่อสินค้า</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">หมวดหมู่</label>
        <input type="text" name="category" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">ราคา (บาท)</label>
        <input type="number" name="price" class="form-control" step="0.01" required>
      </div>

      <div class="mb-3">
        <label class="form-label">จำนวนคงเหลือ</label>
        <input type="number" name="quantity" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success">บันทึกสินค้า</button>
      <a href="index.php" class="btn btn-secondary">ยกเลิก</a>
    </form>
  </div>
</body>
</html>
