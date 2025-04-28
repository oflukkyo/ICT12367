<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ระบบจัดการสินค้าคงคลัง</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <div class="container py-4">
    <h2 class="mb-4">📦 ระบบจัดการสินค้าคงคลัง</h2>

    <!-- ฟอร์มค้นหา -->
    <form method="GET" action="index.php" class="row g-2 mb-4">
      <div class="col-md-3">
        <input type="text" name="product_code" class="form-control" placeholder="ค้นหาด้วยรหัสสินค้า" value="<?= htmlspecialchars($_GET['product_code'] ?? '') ?>">
      </div>
      <div class="col-md-3">
        <input type="text" name="keyword" class="form-control" placeholder="ค้นหาชื่อสินค้า" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
      </div>
      <div class="col-md-2">
        <input type="text" name="search_category" class="form-control" placeholder="ค้นหาหมวดหมู่" value="<?= htmlspecialchars($_GET['search_category'] ?? '') ?>">
      </div>
      <div class="col-md-2">
        <input type="number" step="0.01" name="min_price" class="form-control" placeholder="ราคาต่ำสุด" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
      </div>
      <div class="col-md-2">
        <input type="number" step="0.01" name="max_price" class="form-control" placeholder="ราคาสูงสุด" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">
      </div>
      <div class="col-md-1 d-grid">
        <button type="submit" class="btn btn-primary">ค้นหา</button>
      </div>
      <div class="col-md-1 d-grid">
        <a href="index.php" class="btn btn-secondary">รีเซ็ต</a> <!-- ปุ่มรีเซ็ตแบบล้างค่า -->
      </div>
    </form>

    <!-- ปุ่มเพิ่มสินค้า -->
    <a href="add_product.php" class="btn btn-success mb-3">+ เพิ่มสินค้าใหม่</a>

    <!-- ตารางสินค้า -->
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>รหัสสินค้า</th>
          <th>ชื่อสินค้า</th>
          <th>หมวดหมู่</th>
          <th>ราคา</th>
          <th>จำนวนคงเหลือ</th>
          <th>การจัดการ</th>
        </tr>
      </thead>
      <tbody>
        <?php
          // สร้าง SQL เริ่มต้น
          $sql = "SELECT * FROM products WHERE 1=1";

          // เงื่อนไขการค้นหา
          if (!empty($_GET['product_code'])) {
              $product_code = "%" . $conn->real_escape_string($_GET['product_code']) . "%";
              $sql .= " AND product_code LIKE '$product_code'";
          }
          if (!empty($_GET['keyword'])) {
              $keyword = "%" . $conn->real_escape_string($_GET['keyword']) . "%";
              $sql .= " AND name LIKE '$keyword'";
          }
          if (!empty($_GET['search_category'])) {
              $search_category = "%" . $conn->real_escape_string($_GET['search_category']) . "%";
              $sql .= " AND category LIKE '$search_category'";
          }
          if (isset($_GET['min_price']) && $_GET['min_price'] !== '') {
              $min_price = (float) $_GET['min_price'];
              $sql .= " AND price >= $min_price";
          }
          if (isset($_GET['max_price']) && $_GET['max_price'] !== '') {
              $max_price = (float) $_GET['max_price'];
              $sql .= " AND price <= $max_price";
          }

          // ดึงข้อมูลจากฐานข้อมูล
          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0):
            while($row = $result->fetch_assoc()):
        ?>
          <tr>
            <td><?= htmlspecialchars($row['product_code']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td><?= number_format($row['price'], 2) ?> บาท</td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td>
              <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
              <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือไม่ว่าจะลบ?')">ลบ</a>
            </td>
          </tr>
        <?php
            endwhile;
          else:
        ?>
          <tr>
            <td colspan="6" class="text-center">ไม่พบข้อมูลสินค้า</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
