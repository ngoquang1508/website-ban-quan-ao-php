<?php
require_once "../../config/db.php";
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$order_id = intval($data['order_id']);

$sql = "SELECT oi.*, p.name, p.url_image, o.created_at
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        WHERE oi.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
echo json_encode($items);
exit;
