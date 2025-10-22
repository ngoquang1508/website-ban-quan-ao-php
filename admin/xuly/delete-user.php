
<?php

include __DIR__ . "/../../config/db.php";

$userid = $_GET['id'];

$sql_delete = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql_delete);
$stmt->bind_param("i", $userid);

if (!$stmt->execute()) {
    echo "Lỗi xảy ra!";
    exit;
}

$stmt->close();

header("Location: ../?page=users");
exit;