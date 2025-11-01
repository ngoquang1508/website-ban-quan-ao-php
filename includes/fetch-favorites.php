<?php
function getUserFavorites($conn, $user_id) {
    $favorites = [];
    if ($user_id) {
        $favResult = $conn->query("SELECT product_id FROM favorites WHERE user_id = $user_id");
        while ($row = $favResult->fetch_assoc()) {
            $favorites[] = $row['product_id'];
        }
    }
    return $favorites;
}
?>
