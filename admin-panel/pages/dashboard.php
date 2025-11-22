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


// ==== 2. BIỂU ĐỒ DOANH THU THEO TUẦN ====
$revenuePerWeek = [];
$weeks = [];

$q = $conn->query("
    SELECT 
        YEARWEEK(created_at, 1) AS yw,
        YEAR(created_at) AS y,
        WEEK(created_at, 1) AS w,
        SUM(total_price) AS total
    FROM orders
    GROUP BY yw
    ORDER BY yw
");

while ($row = $q->fetch_assoc()) {
    $weeks[] = "Tuần " . $row['w'] . " (" . $row['y'] . ")";
    $revenuePerWeek[] = $row['total'];
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
    ORDER BY o.created_at DESC 
    LIMIT 6
");


// ==== 5. SẢN PHẨM YÊU THÍCH ====
// Top 6 sản phẩm bán chạy
$favProducts = $conn->query("
    SELECT p.*, COALESCE(SUM(oi.quantity), 0) AS total_sold
    FROM products p
    LEFT JOIN order_items oi ON p.id = oi.product_id
    GROUP BY p.id
    ORDER BY total_sold DESC
    LIMIT 6
");


// ==== 6. User mới ====
$newUsers = $conn->query("
    SELECT * FROM users WHERE role='user' ORDER BY created_at DESC LIMIT 6
");
?>


<style>
    /* Tối ưu hiển thị trên màn hình nhỏ */
    .container-fluid {
        min-width: unset;
    }

    .container-fluid h5 {
        color: blue;
    }

    .kpi h5 {
        font-size: .9rem;
        margin-bottom: .25rem;
        color: #6c757d;
    }

    .kpi h2 {
        margin: 0;
        font-size: 1.6rem;
        word-break: break-word;
    }

    .card .chart-container {
        min-height: 260px;
        position: relative;
    }

    .card canvas {
        width: 100% !important;
        height: 100% !important;
        display: block;
    }

    .product-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: .25rem;
        cursor: pointer;
        position: relative;
    }

    /* tooltip custom */
    .product-img:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.75);
        color: #fff;
        padding: 3px 6px;
        border-radius: 3px;
        white-space: nowrap;
        font-size: 0.75rem;
        pointer-events: none;
    }

    .product-name {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Bắt buộc bảng cuộn ngang trên màn hình nhỏ */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        /* mượt trên di động */
    }

    /* Tối ưu độ rộng bảng để không bị co */
    .table-responsive table {
        width: 100%;
        /* đặt min-width cho bảng */
    }


    @media (max-width: 576px) {
        .kpi h2 {
            font-size: 1.25rem;
        }

        .card .chart-container {
            min-height: 200px;
        }
    }
</style>


<div class="container-fluid p-3">

    <!-- ======= TOP KPIs ======= -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-6 col-md-3">
            <div class="card shadow-sm p-3 kpi">
                <h5>Tổng đơn hàng</h5>
                <h2><?= $totalOrders ?></h2>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-3">
            <div class="card shadow-sm p-3 kpi">
                <h5>Tổng doanh thu</h5>
                <h2><?= number_format($totalRevenue) ?>₫</h2>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-3">
            <div class="card shadow-sm p-3 kpi">
                <h5>Người dùng</h5>
                <h2><?= $totalUsers ?></h2>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-3">
            <div class="card shadow-sm p-3 kpi">
                <h5>Sản phẩm</h5>
                <h2><?= $totalProducts ?></h2>
            </div>
        </div>
    </div>

    <!-- ======= BIỂU ĐỒ ======= -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-3">
                <h5>Doanh thu theo tuần</h5>
                <div class="chart-container mt-2">
                    <canvas id="revenueChart" aria-label="Doanh thu theo tháng" role="img"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card shadow-sm p-3">
                <h5>Top sản phẩm bán chạy</h5>
                <div class="chart-container mt-2">
                    <canvas id="topProductChart" aria-label="Top sản phẩm bán chạy" role="img"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= ĐƠN HÀNG GẦN ĐÂY ======= -->
    <div class="card shadow-sm p-3 mb-4">
        <h5 class="mb-3">Đơn hàng gần đây</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khách</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Ngày</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($o = $recentOrders->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $o['username'] ?? "Guest" ?></td>
                            <td><?= number_format($o['total_price']) ?>₫</td>
                            <td><?= strtoupper($o['payment_method']) ?></td>
                            <td><?= date("d/m/Y", strtotime($o['created_at'])) ?></td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-info"
                                    onclick='showDashboardOrderDetail(<?= json_encode($o) ?>)'>Xem chi tiết</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ======= SẢN PHẨM YÊU THÍCH ======= -->
    <div class="card shadow-sm p-3 mb-4">
        <h5 class="mb-3">Top 6 sản phẩm được yêu thích nhất</h5>
        <div class="row g-2">
            <?php while ($p = $favProducts->fetch_assoc()): ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
                    <img src="<?= BASE_URL . "../" . $p['url_image'] ?>" class="product-img" alt="<?= htmlspecialchars($p['name']) ?>"
                        title="Đã bán: <?= $p['total_sold'] ?>">
                    <p class="fw-bold mt-2 mb-0 product-name"><?= htmlspecialchars($p['name']) ?></p>
                    <small class="text-muted"><?= number_format($p['price']) ?>₫</small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- ======= USER MỚI ======= -->
    <div class="card shadow-sm p-3 mb-4">
        <h5 class="mb-3">Người dùng mới</h5>
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($u = $newUsers->fetch_assoc()): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $u['username'] ?></td>
                            <td><?= $u['email'] ?></td>
                            <td><?= date("H:i d-m-Y", strtotime($u['created_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<!-- Modal chi tiết đơn hàng -->
<div class="modal fade" id="dashboardOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Thông tin người mua -->
                <div class="mb-3">
                    <p><strong>Khách hàng:</strong> <span id="modalCustomerName"></span></p>
                    <p><strong>Email:</strong> <span id="modalCustomerEmail"></span></p>
                    <p><strong>Điện thoại:</strong> <span id="modalCustomerPhone"></span></p>
                    <p><strong>Địa chỉ:</strong> <span id="modalCustomerAddress"></span></p>
                    <p><strong>Ghi chú:</strong> <span id="modalCustomerNote"></span></p>
                    <p><strong>Thanh toán:</strong> <span id="modalPaymentMethod"></span></p>
                    <p><strong>Tổng đơn:</strong> <span id="modalTotalPrice"></span>₫</p>
                    <div style="display: flex; justify-content: flex-start; align-items: center; gap: 1.5rem;">
                        <p><strong>Ngày tạo:</strong> <span id="modalCustomerDate"></span></p>
                        <p><strong>Thời gian:</strong> <span id="modalCustomerTime"></span></p>
                    </div>
                </div>

                <!-- Danh sách sản phẩm -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                        </tr>
                    </thead>
                    <tbody id="dashboardOrderItems">
                        <!-- JS sẽ điền dữ liệu -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<!-- ================== BIỂU ĐỒ JS ================== -->
<script>
    const ctx1 = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: <?= json_encode($weeks) ?>,
            datasets: [{
                label: 'Doanh thu theo tuần (VND)',
                data: <?= json_encode($revenuePerWeek) ?>,
                borderWidth: 3,
                backgroundColor: 'rgba(54,162,235,0.1)',
                borderColor: 'rgba(54,162,235,1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    const ctx2 = document.getElementById('topProductChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?= json_encode($topProductsLabel) ?>,
            datasets: [{
                label: 'Số lượng bán',
                data: <?= json_encode($topProductsQty) ?>,
                borderWidth: 1,
                backgroundColor: 'rgba(255,99,132,0.6)',
                borderColor: 'rgba(255,99,132,1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        // Hiển thị tên đầy đủ khi hover
                        title: function(tooltipItems) {
                            return tooltipItems[0].label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        callback: function(value, index) {
                            const label = this.getLabelForValue(index);
                            // Rút gọn nếu > 10 ký tự
                            return label.length > 10 ? label.substr(0, 10) + '…' : label;
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>

<script>
    function showDashboardOrderDetail(order) {
        const d = new Date(order.created_at);
        const formatted =
            String(d.getDate()).padStart(2, "0") + "/" +
            String(d.getMonth() + 1).padStart(2, "0") + "/" +
            d.getFullYear() + " " +
            d.getHours() + "h" +
            d.getMinutes() + "p" +
            d.getSeconds() + "s";
        // Thông tin người mua
        document.getElementById('modalCustomerName').textContent = order.name || 'Guest';
        document.getElementById('modalCustomerEmail').textContent = order.email;
        document.getElementById('modalCustomerPhone').textContent = order.phone;
        document.getElementById('modalCustomerAddress').textContent = order.address;
        document.getElementById('modalCustomerNote').textContent = order.note || '-';
        document.getElementById('modalPaymentMethod').textContent = order.payment_method.toUpperCase();
        document.getElementById('modalTotalPrice').textContent = new Intl.NumberFormat().format(order.total_price);
        document.getElementById('modalCustomerDate').textContent = formatted.split(" ")[0];
        document.getElementById('modalCustomerTime').textContent = formatted.split(" ")[1];

        // Lấy danh sách sản phẩm
        fetch('api/orders.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    order_id: order.id
                })
            })
            .then(res => res.json())
            .then(items => {
                const tbody = document.getElementById('dashboardOrderItems');
                tbody.innerHTML = '';
                if (items.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">Không có sản phẩm</td></tr>';
                } else {
                    items.forEach((item, index) => {
                        const total = parseFloat(item.price) * parseInt(item.quantity);
                        tbody.innerHTML += `
                    <tr>
                        <td>${index+1}</td>
                        <td><img src="../${item.url_image}" style="width:50px;height:50px;object-fit:cover;"></td>
                        <td>${item.name}</td>
                        <td>${new Intl.NumberFormat().format(item.price)}₫</td>
                        <td>${item.quantity}</td>
                        <td>${new Intl.NumberFormat().format(total)}₫</td>
                    </tr>
                `;
                    });
                }
                const myModal = new bootstrap.Modal(document.getElementById('dashboardOrderModal'));
                myModal.show();
            })
            .catch(err => console.error(err));
    }
</script>