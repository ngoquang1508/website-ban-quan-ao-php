<?php
require_once "../../config/db.php";

header('Content-Type: application/json');

$data = [];
if (!isset($_GET['action'], $_GET['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Thiếu dữ liệu']);
    exit;
}

$action = $_GET['action'];
$id = (int)$_GET['id'];

if (!in_array($action, ['ban', 'unban'])) {
    echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
    exit;
}

// Cập nhật trạng thái
$status = ($action === 'ban') ? 'ban' : 'unlock';

$stmt = $conn->prepare("UPDATE users SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'new_status' => $status]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Cập nhật thất bại']);
}
