<?php

function breadCrumb($page)
{
    $pages = [
        // pages
        "nu" => [
            "title" => "Nữ",
        ],
        "nam" => [
            "title" => "Nam",
        ],
        "tintuc" => [
            "title" => "Tin tức",
        ],
        "lienhe" => [
            "title" => "Liên hệ",
        ],
        "hethongcuahang" => [
            "title" => "Hệ thống cửa hàng",
        ],
        "tim-kiem" => [
            "title" => "Tìm kiếm",
        ],

        // profile
        "thongtincanhan" => [
            "title" => "Thông tin cá nhân",
        ],

        // auth
        "dangnhap" => [
            "title" => "Đăng nhập tài khoản",
        ],
        "dangky" => [
            "title" => "Đăng ký tài khoản",
        ],
        "quenmatkhau" => [
            "title" => "Quên mật khẩu",
        ],
        "doimatkhau" => [
            "title" => "Đặt lại mật khẩu",
        ],
    ];
    $root = '<a href="/">Trang chủ</a>';

    return "<span class='bread-crumb'>{$root} &gt; <strong>{$pages[$page]['title']}</strong></span>";
}

// hàm format price
function formatPrice($price) {
    return number_format($price, 0, ",", ".");
}