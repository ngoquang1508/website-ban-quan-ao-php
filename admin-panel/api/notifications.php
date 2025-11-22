<?php
session_start();
require_once "../../config/db.php";

$action = $_GET['action'] ?? 'list';

// Khởi tạo mảng lưu notification đã xóa
if (!isset($_SESSION['deleted_notifs'])) $_SESSION['deleted_notifs'] = [];

switch ($action) {
    case 'list':
        // Lấy thời gian check lần trước
        $lastChecked = $_SESSION['last_checked'] ?? '2000-01-01 00:00:00';

        // Lấy các đơn hàng mới
        $query = $conn->query("
            SELECT o.id, u.username, o.total_price, o.created_at
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            WHERE o.created_at > '$lastChecked'
            ORDER BY o.created_at DESC
        ");

        $orders = [];
        while ($o = $query->fetch_assoc()) {
            if (!in_array($o['id'], $_SESSION['deleted_notifs'])) {
                $orders[] = $o;
            }
        }

        // Cập nhật thời gian check lần này
        $_SESSION['last_checked'] = date("Y-m-d H:i:s");

        echo json_encode($orders);
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            if (!in_array($id, $_SESSION['deleted_notifs'])) {
                $_SESSION['deleted_notifs'][] = $id;
            }
        }
        echo json_encode(['status' => 'success']);
        break;

    case 'deleteAll':
        $_SESSION['deleted_notifs'] = [];
        echo json_encode(['status' => 'success']);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Action không hợp lệ']);
        break;
}
