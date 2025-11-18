<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user']['id'] ?? null;

$action = $data['action'];

/**
 * CẬP NHẬT THÔNG TIN CÁ NHÂN
 */

if ($action === "update_info") {
    $username = $data['username'] ?? "";
    $phone = $data['phone'] ?? "";
    $address = $data['address'] ?? "";

    $stmt_info = $conn->prepare("UPDATE users SET username = ?, phone = ?, address = ? WHERE id = ?");
    $stmt_info->bind_param("sssi", $username, $phone, $address, $user_id);
    if (!$stmt_info->execute()) {
        echo json_encode([
            "status" => "error",
            "message" => "Lỗi server"
        ]);
        exit;
    } else {
        echo json_encode([
            "status" => "success",
            "message" => "Cập nhật tài khoản thành công!"
        ]);
        exit;
    }
}


/**
 * ĐỔI MẬT KHẨU
 */

if ($action === "change_pass") {
    $input_pass_old = $data['input_pass_old'];
    $input_pass_new = $data['input_pass_new'];

    function checkPassById($conn, $user_id, $input_pass)
    {
        // Lấy mật khẩu hash từ DB
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        if (!$result) {
            return false; // Không tìm thấy user
        }

        $hashed_pass = $result['password'];

        // So sánh password nhập vào với password hash
        return password_verify($input_pass, $hashed_pass);
    }

    // Kiểm tra nếu không đúng -> trả về thông báo
    if (!checkPassById($conn, $user_id, $input_pass_old)) {
        echo json_encode([
            "status" => "error",
            "message" => "Mật khẩu cũ không đúng!"
        ]);
        exit;
    }

    // Băm mật khẩu mới
    $new_pass_hashed = password_hash($input_pass_new, PASSWORD_DEFAULT);

    // Cập nhật mật khẩu mới theo id
    $stmt_change_pw = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt_change_pw->bind_param("si", $new_pass_hashed, $user_id);

    if (!$stmt_change_pw->execute()) {
        echo json_encode([
            "status" => "error",
            "message" => "Lỗi server"
        ]);
        exit;
    } else {
        echo json_encode([
            "status" => "success",
            "message" => "Đổi mật khẩu thành công!"
        ]);
        exit;
    }
}
