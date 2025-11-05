<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(["status" => "error", "message" => "Bạn chưa đăng nhập"]);
    exit;
}

$user_id = $_SESSION['user']['id'];
$data = json_decode(file_get_contents("php://input"), true);

$action = $data['action'] ?? 'update'; // update / add / delete
$product_id = isset($data['product_id']) ? (int)$data['product_id'] : null;
$quantity = isset($data['quantity']) ? (int)$data['quantity'] : 1;


if (!$product_id) {
    echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu product_id"]);
    exit;
}

// Lấy stock và giá sản phẩm
$stockResult = $conn->prepare("SELECT stock, price FROM products WHERE id = ?");
$stockResult->bind_param("i", $product_id);
$stockResult->execute();
$product = $stockResult->get_result()->fetch_assoc();

if (!$product) {
    echo json_encode(["status" => "error", "message" => "Sản phẩm không tồn tại"]);
    exit;
}

switch ($action) {
    case 'add':
        // Thêm sản phẩm (nếu chưa có)
        $stmt_check = $conn->prepare("SELECT * FROM cards WHERE user_id = ? AND product_id = ?");
        $stmt_check->bind_param("ii", $user_id, $product_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(["status" => "info", "message" => "Sản phẩm đã có trong giỏ hàng"]);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO cards(user_id, product_id, quantity) VALUES(?,?,?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Thêm sản phẩm thành công"]);
        exit;

    case 'update':
        // Giới hạn số lượng
        if ($quantity < 1) $quantity = 1;
        if ($quantity > $product['stock']) $quantity = $product['stock'];

        $stmt = $conn->prepare("UPDATE cards SET quantity = ? WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("iii", $quantity, $product_id, $user_id);
        $stmt->execute();

        echo json_encode([
            "status" => "success",
            "new_item_total" => $product['price'] * $quantity
        ]);
        exit;

    case 'delete':
        $stmt = $conn->prepare("DELETE FROM cards WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $product_id, $user_id);
        $stmt->execute();

        echo json_encode([
            "status" => "success",
            "message" => "Xóa sản phẩm thành công"
        ]);
        exit;

    default:
        echo json_encode(["status" => "error", "message" => "Action không hợp lệ"]);
        exit;
}
