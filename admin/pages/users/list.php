<?php

include __DIR__ . "/../../../config/db.php";

// Lấy danh sách tất cả user (trừ admin)
$sql_user = "SELECT id, username, email, phone, address, status, role FROM users WHERE role != 'admin'";
$users = $conn->query($sql_user);

// Biến đếm STT
$i = 1;
?>

<div class="main-user__container">
    <h1 class="main-user__title">Danh sách người dùng</h1>

    <!-- Thông báo lỗi -->
    <?php if (isset($_SESSION['error'])): ?>
        <p class="main-user__no_result">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </p>
    <?php endif; ?>

    <!-- Kết quả tìm kiếm (nếu có) -->
    <?php if (isset($_SESSION['search_user_result'])): 
        $search_results = $_SESSION['search_user_result'];
        unset($_SESSION['search_user_result']);
    ?>
        
        <h2 style="margin-top: 20px;">Kết quả tìm kiếm</h2>

        <?php if (!empty($search_results)): ?>
            <table class="main-user__table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($search_results as $index => $row): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($row['address'] ?? '-'); ?></td>
                            <td><?php echo $row['status'] === 'unlock' ? 'Hoạt động' : 'Bị khóa'; ?></td>
                            <td class="main-user__btn">
                                <a class="main-user__btn-edit" href="?page=users&action=edit&id=<?php echo $row['id']; ?>">Sửa</a>
                                <a class="main-user__btn-delete" href="xuly/delete-user.php?id=<?php echo $row['id']; ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="main-user__no_result">Không tìm thấy người dùng nào phù hợp.</p>
        <?php endif; ?>

    <!-- Danh sách người dùng thường -->
    <?php else: ?>
        <?php if ($users && $users->num_rows > 0): ?>
            <table class="main-user__table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone'] ?? '-'); ?></td>
                            <td><?php echo htmlspecialchars($row['address'] ?? '-'); ?></td>
                            <td><?php echo $row['status'] === 'unlock' ? 'Hoạt động' : 'Bị khóa'; ?></td>
                            <td class="main-user__btn">
                                <a class="main-user__btn-edit" href="?page=users&action=edit&id=<?php echo $row['id']; ?>">Sửa</a>
                                <a class="main-user__btn-delete" href="xuly/delete-user.php?id=<?php echo $row['id']; ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="main-user__empty">Không có người dùng nào trong hệ thống.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
    // Xác nhận trước khi xóa
    document.querySelectorAll('.main-user__btn-delete').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Bạn có chắc chắn muốn xóa người dùng này không?')) {
                e.preventDefault();
            }
        });
    });
</script>