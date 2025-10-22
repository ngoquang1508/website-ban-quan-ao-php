<?php

session_start();

// Xóa toàn bộ dữ liệu trong session
session_unset(); // Xóa biến session
session_destroy(); // Hủy biến session hoàn toàn

// Chuyển về trang đăng nhập
header("Location: ../?page=dangnhap");