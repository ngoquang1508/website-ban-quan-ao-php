<?php
// Lấy tất cả đơn hàng
$sql_orders = "SELECT o.*, u.username 
               FROM orders o 
               LEFT JOIN users u ON o.user_id = u.id
               ORDER BY o.id DESC";
$orders = $conn->query($sql_orders);
?>

<div class="container-fluid p-3">
    <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
        <h3>Quản lý đơn hàng</h3>
        <button class="btn btn-success" id="exportExcelBtn">Xuất excel</button>
    </div>

<div class="card shadow-sm p-3 mt-3">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" data-table="<?= $_GET['page'] ?>">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Khách hàng</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Ngày</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                while ($o = $orders->fetch_assoc()): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td class="search-field"><?= $o['username'] ?? "Guest" ?></td>
                        <td><?= number_format($o['total_price']) ?>₫</td>
                        <td><?= strtoupper($o['payment_method']) ?></td>
                        <td><?= date("d/m/Y", strtotime($o['created_at'])) ?></td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-sm btn-info"
                                onclick='showOrderDetail(<?= json_encode($o, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Modal Order Detail -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Khách hàng:</strong> <span id="orderCustomer"></span></p>
                <p><strong>Email:</strong> <span id="orderEmail"></span></p>
                <p><strong>Điện thoại:</strong> <span id="orderPhone"></span></p>
                <p><strong>Địa chỉ:</strong> <span id="orderAddress"></span></p>
                <p><strong>Ghi chú:</strong> <span id="orderNote"></span></p>
                <p><strong>Thanh toán:</strong> <span id="orderPayment"></span></p>
                <p><strong>Tổng tiền:</strong> <span id="orderTotal"></span>₫</p>
                <div style="display: flex; justify-content: flex-start; align-items: center; gap: 2rem;">
                    <p><strong>Ngày đặt:</strong> <span id="orderDate"></span></p>
                    <p><strong>Giờ đặt:</strong> <span id="orderTime"></span></p>
                </div>

                <hr>
                <h6>Sản phẩm trong đơn:</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="orderItemsBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showOrderDetail(order) {
        const d = new Date(order.created_at);
        const formatted =
            String(d.getDate()).padStart(2, "0") + "/" +
            String(d.getMonth() + 1).padStart(2, "0") + "/" +
            d.getFullYear() + " " +
            d.getHours() + "h" +
            d.getMinutes() + "p" +
            d.getSeconds() + "s";

        document.getElementById('orderCustomer').textContent = order.name || 'Guest';
        document.getElementById('orderEmail').textContent = order.email;
        document.getElementById('orderPhone').textContent = order.phone;
        document.getElementById('orderAddress').textContent = order.address;
        document.getElementById('orderNote').textContent = order.note || '-';
        document.getElementById('orderPayment').textContent = order.payment_method.toUpperCase();
        document.getElementById('orderTotal').textContent = new Intl.NumberFormat().format(order.total_price);
        document.getElementById('orderDate').textContent = formatted.split(" ")[0];
        document.getElementById('orderTime').textContent = formatted.split(" ")[1];

        // Lấy danh sách sản phẩm bằng fetch API
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
            .then(data => {
                const tbody = document.getElementById('orderItemsBody');
                tbody.innerHTML = '';
                data.forEach(item => {
                    const row = `<tr>
                <td><img src="<?= BASE_URL . '../' ?>${item.url_image}" style="width:50px;height:50px;object-fit:cover;"></td>
                <td>${item.name}</td>
                <td>${new Intl.NumberFormat().format(item.price)}</td>
                <td>${item.quantity}</td>
                <td>${new Intl.NumberFormat().format(item.price * item.quantity)}</td>
            </tr>`;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            });

        var myModal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
        myModal.show();
    }
</script>

<script src="<?= BASE_URL ?>assets/js/excel.js"></script>