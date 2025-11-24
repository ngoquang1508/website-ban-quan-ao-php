<?php
require_once "../config/db.php";

// Lấy danh sách người dùng (trừ admin)
$sql_user = "SELECT id, username, email, phone, address, status, role, created_at 
             FROM users 
             WHERE role != 'admin'
             ORDER BY id DESC";
$users = $conn->query($sql_user);
?>

<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .badge-active {
        background: #28a745;
    }

    .badge-banned {
        background: #dc3545;
    }
</style>

<div class="container-fluid p-3">

    <div class="card shadow-sm p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <h4 class="mb-3">Quản lý người dùng</h4>
            <button class="btn btn-success" id="exportExcelBtn">Xuất excel</button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle" data-table="<?= $_GET['page'] ?>">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Địa chỉ</th>
                        <th>Quyền</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th class="text-center">Chức năng</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $i = 1;
                    while ($u = $users->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td class="search-field"><?= $u['username'] ?></td>
                            <td class="search-field"><?= $u['email'] ?></td>
                            <td><?= $u['phone'] ?? "-" ?></td>
                            <td class="search-field"><?= $u['address'] ?? "-" ?></td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    <?= strtoupper($u['role']) ?>
                                </span>
                            </td>

                            <td>
                                <?php if ($u['status'] == "unlock"): ?>
                                    <span class="badge badge-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge badge-banned">Bị khóa</span>
                                <?php endif; ?>
                            </td>

                            <td><?= date("d/m/Y", strtotime($u['created_at'])) ?></td>

                            <td class="text-center">
                                <button class="btn btn-sm <?= $u['status'] == "unlock" ? "btn-danger" : "btn-success" ?>"
                                    onclick="toggleUser(<?= $u['id'] ?>, this)">
                                    <?= $u['status'] == "unlock" ? "Khóa" : "Mở khóa" ?>
                                </button>
                            </td>

                        </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- MỞ / KHÓA TÀI KHOẢN -->
<script>
    const toggleUser = async (id, btn) => {
        const isBan = btn.textContent.trim() === "Khóa";
        const action = isBan ? "ban" : "unban";

        if (!confirm(`${isBan ? "Khóa" : "Mở khóa"} tài khoản này?`)) return;

        showLoading();

        try {
            const res = await fetch(`api/users.php?action=${action}&id=${id}`);
            const data = await res.json();

            if (data.status === "success") {

                const statusCell = btn.closest("tr").querySelector("td:nth-child(7) span");

                if (data.new_status === "ban") {
                    btn.textContent = "Mở khóa";
                    btn.classList.remove("btn-danger");
                    btn.classList.add("btn-success");

                    statusCell.textContent = "Bị khóa";
                    statusCell.className = "badge badge-banned";

                    showSuccess("Đã khóa tài khoản!");
                } else {
                    btn.textContent = "Khóa";
                    btn.classList.remove("btn-success");
                    btn.classList.add("btn-danger");

                    statusCell.textContent = "Hoạt động";
                    statusCell.className = "badge badge-active";

                    showSuccess("Đã mở khóa tài khoản!");
                }

            } else {
                alert(data.message);
            }

        } catch (err) {
            console.error(err);
            alert("Lỗi kết nối máy chủ!");
        }

        hideLoading();
    }
</script>

<script src="<?= BASE_URL ?>assets/js/excel.js"></script>