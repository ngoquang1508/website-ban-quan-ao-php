<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Bạn cần đăng nhập để thêm sản phẩm yêu thích."
    ]);
    exit;
}

$user_id = $_SESSION['user']['id'];
$product_id = $_POST['product_id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$product_id || !$action) {
    echo json_encode([
        "status" => "error",
        "message" => "Thiếu dữ liệu."
    ]);
    exit;
}

if ($action == 'add') {
    $sql = "INSERT IGNORE INTO favorites(user_id, product_id) VALUES(?,?)";
} elseif ($action == "remove") {
    $sql = "DELETE FROM favorites WHERE user_id = ? AND product_id = ?";
} else {
    echo json_encode([
        "status" => "error",
        "message" => "action không hợp lệ."
    ]);
    exit;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

echo json_encode(["status" => "success"]);
exit;
