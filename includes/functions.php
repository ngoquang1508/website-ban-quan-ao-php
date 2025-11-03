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
        "lien-he" => [
            "title" => "Liên hệ",
        ],
        "he-thong-cua-hang" => [
            "title" => "Hệ thống cửa hàng",
        ],
        "tim-kiem" => [
            "title" => "Tìm kiếm",
        ],
        "yeu-thich" => [
            "title" => "Yêu thích",
        ],
        "chi-tiet-san-pham" => [
            "title" => "Chi tiết sản phẩm",
        ],

        // profile
        "thong-tin-ca-nhan" => [
            "title" => "Thông tin cá nhân",
        ],

        // auth
        "dang-nhap" => [
            "title" => "Đăng nhập tài khoản",
        ],
        "dang-ky" => [
            "title" => "Đăng ký tài khoản",
        ],
        "quen-mat-khau" => [
            "title" => "Quên mật khẩu",
        ],
        "doi-mat-khau" => [
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