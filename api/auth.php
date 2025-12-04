<?php
session_start();
require_once "../config/db.php";

header("Content-Type: application/json; charset=UTF-8");

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data || !isset($data['action'])) {
    echo json_encode(["status" => "error", "message" => "Dữ liệu không hợp lệ"]);
    exit;
}

$action = $data['action'];

switch ($action) {
    case 'dang-nhap':
        $email = $data['email'];
        $password = $data['password'];

        // validate
        if (!$email || !$password) {
            echo json_encode([
                "status" => "error",
                "message" => "Thiếu email hoặc password"
            ]);
            exit;
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user || !password_verify($password, $user['password'])) {
            echo json_encode([
                "status" => "error",
                "message" => "Email hoặc mật khẩu không đúng!"
            ]);
            exit;
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

        echo json_encode([
            "status" => "success",
            "message" => "Đăng nhập thành công",
            "role" => $user['role']
        ]);
        break;

    case 'dang-ky':
        $fullname = $data['hoten'];
        $email = $data['email'];
        $password = $data['password'];
        $confirm_password = $data['confirm_password'];

        // validate
        if (!$fullname || !$email || !$password || !$confirm_password) {
            echo json_encode([
                "status" => "error",
                "message" => "Thiếu thông tin!"
            ]);
            exit;
        }

        if (strlen($fullname) < 3) {
            echo json_encode([
                "status" => "error",
                "message" => "Tên người dùng không nhỏ hơn 3 ký tự!"
            ]);
            exit;
        }

        if (!$password !== !$confirm_password) {
            echo json_encode([
                "status" => "error",
                "message" => "Mật khẩu nhập lại không khớp!"
            ]);
            exit;
        }

        // Kiểm tra email tồn tại
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            echo json_encode([
                "status" => "error",
                "message" => "Email đã tồn tại!"
            ]);
            exit;
        }

        $role = "user";
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt_insert = $conn->prepare("INSERT INTO users(username, email, password, role) VALUES (?,?,?,?)");
        $stmt_insert->bind_param("ssss", $fullname, $email, $hash, $role);
        $stmt_insert->execute();

        echo json_encode([
            "status" => "success",
            "message" => "Đăng ký thành công"
        ]);

        break;

    case 'dang-xuat':
        // Xóa toàn bộ dữ liệu trong session
        session_unset(); // Xóa biến session
        session_destroy(); // Hủy biến session hoàn toàn

        break;

    case 'quen-mat-khau':
        $email = $data['email'];

        $stmt = $conn->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        if ($stmt->get_result()->num_rows === 0) {
            echo json_encode([
                "status" => "error",
                "message" => "Email không tồn tại!"
            ]);
            exit;
        }

        // Lưu session cho đổi mật khẩu
        $_SESSION['reset_email'] = $email;

        echo json_encode([
            "status" => "success"
        ]);
        break;

    case 'doi-mat-khau':
        if (!isset($_SESSION['reset_email'])) {
            echo json_encode([
                "status" => "error",
                "message" => "Không có email để đặt lại mật khẩu!"
            ]);
            exit;
        }

        $email = $_SESSION['reset_email'];
        $password = $data['password'];
        $confirm = $data['confirm_password'];

        if ($password !== $confirm) {
            echo json_encode([
                "status" => "error",
                "message" => "Mật khẩu xác nhận không khớp!"
            ]);
            exit;
        }

        if (strlen($password) < 6) {
            echo json_encode([
                "status" => "error",
                "message" => "Mật khẩu phải ít nhất 6 ký tự!"
            ]);
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hash, $email);
        $stmt->execute();

        // XÓA SESSION SAU KHI ĐỔI MẬT KHẨU
        unset($_SESSION['reset_email']);

        echo json_encode([
            "status" => "success",
            "message" => "Đổi mật khẩu thành công!"
        ]);
        break;

    default:
        echo json_encode([
            "status" => "error",
            "message" => "Lỗi server!"
        ]);
        exit;
}
