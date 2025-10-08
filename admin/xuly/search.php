<?php
session_start();

include __DIR__ . "/../../config/db.php";

$value = $_POST['value'];
$page = $_POST['page'];
$action = $_POST['action'] ?? "";

// Nếu tồn tại action thì không cho phép tìm kiếm và quay lại trang đó
if (!empty($action)) {
    echo "Lỗi tìm kiếm tồn tại action";

    if (isset($_POST['id'])) {
        header("Location: ../index.php?page=" . $page . "&action=" . $action . "&id=" . $_POST['id']);
        exit;
    }

    header("Location: ../index.php?page=" . $page . "&action=" . $action);
    exit;
}

if ($page === "users") {
    $sql_search_users = "SELECT * FROM users WHERE role = 'user' AND (username LIKE ? OR SUBSTRING_INDEX(email, '@', 1) LIKE ?)";
    $search_user = "%" . $value . "%";

    $stmt = $conn->prepare($sql_search_users);
    $stmt->bind_param("ss", $search_user, $search_user);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Không tìm thấy kết quả";
    } else {
        $_SESSION['search_user_result'] = $result->fetch_all(MYSQLI_ASSOC) ?? [];
    }
    $stmt->close();
} elseif ($page === "products") {
    $sql_search_product = "SELECT * FROM products WHERE name LIKE ?";
    $search_product = "%" . $value . "%";
    $stmt = $conn->prepare($sql_search_product);
    $stmt->bind_param("s", $search_product);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Không tìm thấy kết quả";
    } else {
        $_SESSION['search_product_result'] = $result->fetch_all(MYSQLI_ASSOC) ?? [];
    }
    $stmt->close();
}

header("Location: ../index.php?page=" . $page);
exit;
