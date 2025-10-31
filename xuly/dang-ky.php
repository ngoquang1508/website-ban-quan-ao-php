<?php
include_once __DIR__ . "/../config/db.php";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $username = trim($_POST['hoten']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra ten nguoi dung hợp lệ
    if (strlen($username) < 2) {
        echo "<p>Tên người dùng phải từ 2 ký tự trở lên</p>";
        exit;
    }

    // Kiểm tra email đã tồn tại chưa
    $sqlCheckEmail = "SELECT email FROM users WHERE email = ?";
    $stmtEmail = $conn->prepare($sqlCheckEmail);
    $stmtEmail->bind_param("s", $email);
    $stmtEmail->execute();
    $result = $stmtEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<p>Email đã tồn tại</p>";
        $stmtEmail->close();
        $conn->close();
        exit;
    }
    $stmtEmail->close();

    // Kiểm tra mật khẩu và xác nhận mật khẩu
    if ($password !== $confirm_password) {
        echo "<p>Mật khẩu không khớp</p>";
        $conn->close();
        exit;
    }

    // Băm mật khẩu
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    // Thêm người dùng mới
    $sql = "INSERT INTO users(username, email, password, role) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $role = 'user';
    $stmt->bind_param("ssss", $username, $email, $pass_hash, $role);

    if ($stmt->execute()) {
        echo "<p>Tạo tài khoản thành công</p>";
        header("Location: ../?page=dang-nhap");
        exit;
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
