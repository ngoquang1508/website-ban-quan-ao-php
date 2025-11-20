<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL);

$user_id = $_SESSION['user']['id'] ?? null;

// Lấy action (ưu tiên JSON → form-data → query)
$raw = file_get_contents("php://input");
$body = json_decode($raw, true) ?? [];
$action = $body['action']
    ?? ($_POST['action'] ?? ($_GET['action'] ?? ''));

// Helper trả JSON
function jsonResponse($status, $message, $extra = [])
{
    echo json_encode(array_merge([
        "status" => $status,
        "message" => $message
    ], $extra));
    exit;
}

// Đảm bảo user đã đăng nhập
if (!$user_id) {
    jsonResponse("error", "Bạn chưa đăng nhập!");
}

/* ============================================================
   CẬP NHẬT THÔNG TIN CÁ NHÂN
   ============================================================ */
if ($action === "update_info") {
    $username = $body['username'] ?? "";
    $phone    = $body['phone'] ?? "";
    $address  = $body['address'] ?? "";

    $stmt = $conn->prepare("UPDATE users SET username=?, phone=?, address=? WHERE id=?");
    $stmt->bind_param("sssi", $username, $phone, $address, $user_id);

    $ok = $stmt->execute();
    jsonResponse($ok ? "success" : "error", $ok ? "Cập nhật tài khoản thành công!" : "Lỗi server");
}

/* ============================================================
   UPLOAD ẢNH ĐẠI DIỆN
   ============================================================ */
if ($action === "upload_avatar") {
    if (!isset($_FILES['avatar'])) {
        jsonResponse("error", "Không có file được gửi");
    }

    $file = $_FILES['avatar'];
    $allowed = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($file["type"], $allowed)) {
        jsonResponse("error", "Chỉ chấp nhận ảnh jpg, png, gif");
    }

    if ($file["size"] > 2 * 1024 * 1024) {
        jsonResponse("error", "Ảnh quá lớn (max 2MB)");
    }

    // Lấy avatar cũ từ DB
    $old = $conn->query("SELECT avatar FROM users WHERE id = $user_id")->fetch_assoc();
    $oldAvatar = $old['avatar']; // ví dụ: uploads/avatars/1732000000_meo.png

    // ==== 1. Kiểm tra nếu người dùng upload lại đúng ảnh cũ ====
    if (!empty($oldAvatar)) {
        $oldFileNameOnly = basename($oldAvatar); // 1732000000_meo.png

        if ($oldFileNameOnly === basename($file["name"])) {
            // Trùng tên gốc → có khả năng là trùng file
            jsonResponse("success", "Bạn đã sử dụng ảnh này rồi!", [
                "file" => $oldAvatar
            ]);
        }
    }

    // ==== 2. Upload ảnh mới ====
    $dir = "../uploads/avatars/";
    if (!is_dir($dir)) mkdir($dir, 0777, true);

    $file_name = time() . "_" . basename($file["name"]);
    $path = $dir . $file_name;

    if (!move_uploaded_file($file["tmp_name"], $path)) {
        jsonResponse("error", "Upload thất bại");
    }

    // ==== 3. Xóa ảnh cũ nếu tồn tại ====
    if (!empty($oldAvatar)) {
        $oldPath = "../" . $oldAvatar; // chuyển thành đường dẫn thực tế

        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
    }

    // ==== 4. Lưu đường dẫn avatar mới vào DB ====
    $url = "uploads/avatars/" . $file_name;
    $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
    $stmt->bind_param("si", $url, $user_id);
    if (!$stmt->execute()) {
        jsonResponse("error", "Upload thất bại");
    }

    // Trả về đường dẫn ảnh mới
    jsonResponse("success", "Upload thành công", [
        "file" => $url
    ]);
}


/* ============================================================
   ĐỔI MẬT KHẨU
   ============================================================ */
if ($action === "change_pass") {
    $old = $body['input_pass_old'] ?? "";
    $new = $body['input_pass_new'] ?? "";

    // Lấy mật khẩu hash
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user || !password_verify($old, $user['password'])) {
        jsonResponse("error", "Mật khẩu cũ không đúng!");
    }

    $new_hashed = password_hash($new, PASSWORD_DEFAULT);

    $stmt2 = $conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt2->bind_param("si", $new_hashed, $user_id);

    jsonResponse(
        $stmt2->execute() ? "success" : "error",
        $stmt2->execute() ? "Đổi mật khẩu thành công!" : "Lỗi server"
    );
}

/* ============================================================
   ACTION KHÔNG HỢP LỆ
   ============================================================ */
jsonResponse("error", "Action không hợp lệ");
