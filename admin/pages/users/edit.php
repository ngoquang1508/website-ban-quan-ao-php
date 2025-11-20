<?php

include __DIR__ . "/../../../config/db.php";

$id_user = $_GET["id"] ?? null;

if (!$id_user || !is_numeric($id_user)) {
    header("Location: .. ?page=users");
    exit;
}

$sql_check_id = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql_check_id);
$stmt->bind_param("s", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Nếu không có id user nào khớp -> chặn
if (!$user) {
    header("Location: .. ?page=users");
    exit;
}
$stmt->close();

?>

<div class="edit-user__wrapper">
    <a class="edit-user__go-back" href="?page=users">Quay lại</a>

    <div class="edit-user__container">
        <h2>Sửa user có id = <?php echo $id_user ?></h2>

        <form action="xuly/edit-user.php" method="post">
            <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
            <label for="">Họ tên</label>
            <input type="text" name="username" value="<?php echo $user['username'] ?>">
            <label for="">Email</label>
            <input type="email" name="email" value="<?php echo $user['email'] ?>">
            <label for="">Trạng thái</label>
            <select name="status">
                <option value="unlock" <?= ($user['status'] === 'unlock') ? 'selected' : '' ?>>Hoạt động</option>
                <option value="lock" <?= ($user['status'] === 'lock') ? 'selected' : '' ?>>Khóa</option>
            </select>


            <input type="submit" value="Lưu" name="save">
        </form>

    </div>
</div>