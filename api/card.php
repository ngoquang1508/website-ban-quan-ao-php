<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng."
    ]);
    exit;
}

$user_id = $_SESSION['user']['id'];
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? null;

if (!$product_id) {
    echo json_encode([
        "status" => "error",
        "message" => "Thiếu dữ liệu."
    ]);
    exit;
}

// Kiểm tra đã tồn tại user_id và product_id trong card
$stmt_check = $conn->prepare("SELECT * FROM cards WHERE user_id = ? AND product_id = ?");
$stmt_check->bind_param("ii", $user_id, $product_id);
$stmt_check->execute();
$result = $stmt_check->get_result();
if ($result->num_rows > 0) {
    echo json_encode([
        "status" => "info",
        "message" => "Sản phẩm này đã có trong giỏ hàng của bạn."
    ]);
    exit;
}

$sql = "INSERT IGNORE INTO cards(user_id, product_id, quantity) VALUES(?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $product_id, $quantity);
$stmt->execute();

echo json_encode(["status" => "success"]);
exit;
