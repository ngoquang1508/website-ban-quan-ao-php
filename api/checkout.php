<?php
require_once "../config/db.php";
session_start();

header('Content-Type: application/json');

$user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
if (!$user_id) {
    echo json_encode(["status" => "error", "message" => "Bạn cần đăng nhập để tiếp tục!"]);
    exit;
}

// Lấy dữ liệu JSON từ FE
$json = file_get_contents('php://input');
$data = json_decode($json, true);

error_log(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));


if (!$data || !isset($data['items']) || !is_array($data['items']) || count($data['items']) === 0) {
    echo json_encode(["status" => "error", "message" => "Dữ liệu không hợp lệ"]);
    exit;
}

// Thêm vào orders
$sql_orders = "INSERT INTO orders(user_id, name, email, phone, address, total_price, payment_method, note) VALUES(?,?,?,?,?,?,?,?)";
$stmt_orders = $conn->prepare($sql_orders);
$stmt_orders->bind_param("issssiss", $user_id, $data['name'], $data['email'], $data['phone'], $data['address'], $data['total_price'], $data['payment_method'], $data['note']);
$stmt_orders->execute();

// Lấy order_id vừa tạo
$order_id = $conn->insert_id;

// Thêm các order_items
$sql_item = "INSERT INTO order_items(order_id, product_id, quantity, price) VALUES(?,?,?,?)";
$stmt_item = $conn->prepare($sql_item);

// Chuẩn bị câu lệnh order_history
$sql_history = "INSERT INTO order_history(user_id, product_id, name, price, quantity, total_price, payment_method, url_image) VALUES(?,?,?,?,?,?,?,?)";
$stmt_history = $conn->prepare($sql_history);

foreach ($data['items'] as $item) {
    $stmt_item->bind_param("iiii", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $stmt_item->execute();

    // Update stock (giảm số lượng)
    $conn->query("UPDATE products SET stock = stock - {$item['quantity']} WHERE id = {$item['product_id']}");

    // Lấy thông tin sản phẩm để lưu history
    $product = $conn->query("SELECT name, url_image FROM products WHERE id = {$item['product_id']}")->fetch_assoc();
    $history_name = $product['name'] ?? '';
    $history_image = $product['url_image'] ?? '';

    // Thêm vào order_history
    $price = floatval($item['price']);
    $total_price = $price * intval($item['quantity']) + 40000.00;
    $payment_method = strtoupper($data['payment_method']);

    $stmt_history->bind_param(
        "iisdidss",
        $user_id,
        $item['product_id'],
        $history_name,
        $price,
        $item['quantity'],
        $total_price,
        $payment_method,
        $history_image
    );
    $stmt_history->execute();
}

// Nếu kiểu thanh toán là cart thì xóa danh sách sản phẩm ở trang cart
if ($data['type'] === "cart") {
    $sql = "DELETE FROM carts where user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Lưu SESSION để trang thank-you lấy dữ liệu
$_SESSION['order_success'] = [
    "order_id"       => $order_id,
    "name"           => $data['name'],
    "email"          => $data['email'],
    "phone"          => $data['phone'],
    "address"        => $data['address'],
    "note"           => $data['note'],
    "total_price"    => $data['total_price'],
    "payment_method" => $data['payment_method'],
    "items"          => $data['items']
];

echo json_encode([
    "status" => "success",
    "message" => "Đặt hàng thành công",
]);
