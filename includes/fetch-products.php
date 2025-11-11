<?php
require_once __DIR__ . '/../config/db.php';

/**
 * Đếm tổng số sản phẩm theo điều kiện
 */
function getTotalProduct($where)
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM products WHERE $where";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total'] ?? 0;
}

/**
 * Lấy danh sách sản phẩm theo giới tính + phân trang
 */
function getProducts($where, $start, $limit)
{
    global $conn;
    $sql = "SELECT * FROM products WHERE $where LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $start, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * Xử lý logic phân trang
 */
function getPaginationInfo($totalRow, $limit, $currentPage)
{
    $totalPages = ceil($totalRow / $limit);
    if ($totalPages == 0) $totalPages = 1;
    if ($currentPage < 1) $currentPage = 1;
    if ($currentPage > $totalPages) $currentPage = $totalPages;

    $start = ($currentPage - 1) * $limit;

    return [
        'totalPages' => $totalPages,
        'currentPage' => $currentPage,
        'start' => $start
    ];
}

/**
 * Lấy id sản phẩm người theo id người mua
 */
function getUserCartProductIds($conn, $user_id)
{
    $cartProductIds = [];

    $stmt = $conn->prepare("SELECT product_id FROM carts WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $cartProductIds[] = $row['product_id'];
    }

    return $cartProductIds;
}
