<?php
require_once "../config/db.php";

// ==== 1. THỐNG KÊ =====

// Tổng đơn
$totalOrders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];

// Tổng doanh thu
$totalRevenue = $conn->query("SELECT SUM(total_price) AS sum FROM orders")->fetch_assoc()['sum'] ?? 0;

// Tổng user
$totalUsers = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='user'")->fetch_assoc()['total'];

// Tổng sản phẩm
$totalProducts = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'];


// ==== 2. BIỂU ĐỒ DOANH THU THEO THÁNG ====
$revenuePerMonth = [];
$months = [];

$q = $conn->query("
    SELECT MONTH(created_at) AS m, SUM(total_price) AS total
    FROM orders
    GROUP BY MONTH(created_at)
    ORDER BY m
");

while ($row = $q->fetch_assoc()) {
    $months[] = "Tháng " . $row['m'];
    $revenuePerMonth[] = $row['total'];
}


// ==== 3. TOP SẢN PHẨM BÁN CHẠY ====

$topProductsLabel = [];
$topProductsQty = [];

$tp = $conn->query("
    SELECT p.name, SUM(oi.quantity) AS total_qty
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id
    GROUP BY oi.product_id
    ORDER BY total_qty DESC
    LIMIT 5
");

while ($row = $tp->fetch_assoc()) {
    $topProductsLabel[] = $row['name'];
    $topProductsQty[] = $row['total_qty'];
}


// ==== 4. Đơn hàng gần đây ====
$recentOrders = $conn->query("
    SELECT o.*, u.username 
    FROM orders o 
    LEFT JOIN users u ON o.user_id = u.id 
    ORDER BY o.id DESC 
    LIMIT 6
");


// ==== 5. Sản phẩm mới ====
$recentProducts = $conn->query("
    SELECT * FROM products ORDER BY created_at DESC LIMIT 6
");


// ==== 6. User mới ====
$newUsers = $conn->query("
    SELECT * FROM users ORDER BY created_at DESC LIMIT 6
");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">
<div class="container-fluid p-4">

    <!-- ======= TOP KPIs ======= -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5 class="text-muted">Tổng đơn hàng</h5>
                <h2><?= $totalOrders ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5 class="text-muted">Tổng doanh thu</h5>
                <h2><?= number_format($totalRevenue) ?>₫</h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5 class="text-muted">Người dùng</h5>
                <h2><?= $totalUsers ?></h2>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <h5 class="text-muted">Sản phẩm</h5>
                <h2><?= $totalProducts ?></h2>
            </div>
        </div>
    </div>


    <!-- ======= BIỂU ĐỒ ======= -->
    <div class="row g-4 mb-4">

        <!-- Biểu đồ doanh thu -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5>Doanh thu theo tháng</h5>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Top sản phẩm bán chạy -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5>Top sản phẩm bán chạy</h5>
                <canvas id="topProductChart"></canvas>
            </div>
        </div>
    </div>


    <!-- ======= ĐƠN HÀNG GẦN ĐÂY ======= -->
    <div class="card shadow-sm p-3 mb-4">
        <h5 class="mb-3">Đơn hàng gần đây</h5>
        <table class="table table-hover align-middle">
            <thead>
            <tr>
                <th>ID</th>
                <th>Khách</th>
                <th>Tiền</th>
                <th>Thanh toán</th>
                <th>Ngày</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($o = $recentOrders->fetch_assoc()): ?>
                <tr>
                    <td><?= $o['id'] ?></td>
                    <td><?= $o['username'] ?? "Guest" ?></td>
                    <td><?= number_format($o['total_price']) ?>₫</td>
                    <td><?= strtoupper($o['payment_method']) ?></td>
                    <td><?= date("H:i d-m-Y", strtotime($o['created_at'])) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>


    <!-- ======= SẢN PHẨM GẦN THÊM ======= -->
    <div class="card shadow-sm p-3 mb-4">
        <h5 class="mb-3">Sản phẩm mới</h5>
        <div class="row">
            <?php while ($p = $recentProducts->fetch_assoc()): ?>
                <div class="col-md-2 text-center mb-3">
                    <img src="../<?= $p['url_image'] ?>" class="img-fluid rounded" style="height: 120px; object-fit: cover;">
                    <p class="fw-bold mt-2"><?= $p['name'] ?></p>
                    <span class="text-muted"><?= number_format($p['price']) ?>₫</span>
                </div>
            <?php endwhile; ?>
        </div>
    </div>


    <!-- ======= USER MỚI ======= -->
    <div class="card shadow-sm p-3 mb-4">
        <h5 class="mb-3">Người dùng mới</h5>
        <table class="table table-striped align-middle">
            <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Ngày tạo</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($u = $newUsers->fetch_assoc()): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= $u['username'] ?></td>
                    <td><?= $u['email'] ?></td>
                    <td><?= date("H:i d-m-Y", strtotime($u['created_at'])) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>


<!-- ================== BIỂU ĐỒ JS ================== -->
<script>
const ctx1 = document.getElementById('revenueChart');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: <?= json_encode($months) ?>,
        datasets: [{
            label: 'Doanh thu (VND)',
            data: <?= json_encode($revenuePerMonth) ?>,
            borderWidth: 3
        }]
    }
});

const ctx2 = document.getElementById('topProductChart');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: <?= json_encode($topProductsLabel) ?>,
        datasets: [{
            label: 'Số lượng bán',
            data: <?= json_encode($topProductsQty) ?>,
            borderWidth: 3
        }]
    }
});
</script>

</body>
</html>
