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
