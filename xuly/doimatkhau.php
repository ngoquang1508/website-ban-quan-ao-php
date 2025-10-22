<?php
include_once __DIR__ . "/../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    if ($password !== $confirm) {
        echo "<p>Mật khẩu đặt lại không chính xác</p>";
        exit;
    }

    if (strlen($password) < 6) {
        echo "<p>Mật khẩu phải từ 6 ký tự trở lên</p>";
        exit;
    }

    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $pass_hash, $email);

    if ($stmt->execute()) {
        header("Location: ../?page=dangnhap&success=" . urlencode("Đổi mật khẩu thành công, vui lòng đăng nhập"));
        exit;
    } else {
        header("Location: ../?page=doimatkhaumoi&email=" . urlencode($email) . "&error=" . urlencode("Có lỗi xảy ra, vui lòng thử lại"));
        exit;
    }
}