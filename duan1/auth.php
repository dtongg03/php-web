<?php
session_start();

// Kiểm tra xem đã đăng nhập hay chưa
if (!isset($isLoggedIn)) {
    $isLoggedIn = false;
    $loggedInUsername = "";

    // Xử lý đăng xuất nếu có yêu cầu

    // Nếu chưa đăng nhập, kiểm tra thông tin từ cookie
    if (isset($_COOKIE['user'])) {
        $_SESSION['user'] = $_COOKIE['user'];
        $isLoggedIn = true;
        $loggedInUsername = $_SESSION['user'];
    }
}
?>
