<?php
session_start();
include_once __DIR__ . "/../config/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../?page=dang-nhap");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();

$stmt->close();
$conn->close();

// Check tồn tại user
if (!$user) {
    exit("Email không tồn tại");
}

// Check mật khẩu
if (!password_verify($password, $user['password'])) {
    exit("Mật khẩu không đúng");
}

// Check trạng thái
if ($user['status'] !== 'unlock') {
    exit("Tài khoản này đã bị khóa!");
}

// Lưu session
$_SESSION['user'] = [
    'id'       => $user['id'],
    'username' => $user['username'],
    'email'    => $user['email'],
    'role'     => $user['role'],
    'status'   => $user['status'],
    'avatar'   => $user['avatar'],
];

if (isset($_SESSION['redirect_after_login'])) {
    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']); // xóa sau khi dùng
    header("Location: " . $redirect);
    exit;
}

// Chuyển trang theo role

$redirect = ($user['role'] === 'admin') ? "../admin/" : "../?page=trang-chu";

header("Location: $redirect");

exit;

