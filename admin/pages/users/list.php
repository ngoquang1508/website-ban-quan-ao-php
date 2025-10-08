<?php

include __DIR__ . "/../../../config/db.php";

$sql_user = "SELECT * FROM users";
$users = $conn->query($sql_user);
$i = 1;
?>

<div class="main-user__container">
    <h1 class="main-user__title">Danh sách người dùng</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="main-user__no_result">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']); 
            ?>
        </p>
    <?php elseif (isset($_SESSION['search_user_result'])): 
        $search_results = $_SESSION['search_user_result'];
        unset($_SESSION['search_user_result']); 
    ?>
        
        <h2 style="margin-top: 20px;">Kết quả tìm kiếm</h2>

        <?php if (!empty($search_results)): ?>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($search_results as $row): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?php echo $row['status'] === 'unlock' ? "Hoạt động" : "Bị khóa"; ?>
                            </td>
                            <td class="main-user__btn">
                                <a class="main-user__btn-edit" href="index.php?page=users&action=edit&id=<?php echo $row['id'] ?>">Sửa</a>
                                <a class="main-user__btn-delete" href="xuly/delete-user.php?id=<?php echo $row['id'] ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="main-user__no_result">Không tìm thấy người dùng nào phù hợp.</p>
        <?php endif; ?>

    <?php 
    else: 
    ?>
        <?php if ($users->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $users->fetch_assoc()): ?>
                        <?php if ($row['role'] !== 'admin'): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td>
                                    <?php echo $row['status'] === 'unlock' ? "Hoạt động" : "Bị khóa"; ?>
                                </td>
                                <td class="main-user__btn">
                                    <a class="main-user__btn-edit" href="index.php?page=users&action=edit&id=<?php echo $row['id'] ?>">Sửa</a>
                                    <a class="main-user__btn-delete" href="xuly/delete-user.php?id=<?php echo $row['id'] ?>">Xóa</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="main-user__empty">Không có người dùng nào trong hệ thống.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
    document.querySelectorAll('.main-user__btn-delete').forEach(btn => {
        btn.addEventListener('click', function(event) {
            if (!confirm("Bạn có chắc chắn xóa user này không?")) {
                event.preventDefault();
            }
        });
    });
</script>