<?php
    require_once('../admin/includes/jwt-helper.php');

// Kiểm tra và xác thực JWT
if (isset($_COOKIE['auth_token'])) {
    $decoded = verifyJWT($_COOKIE['auth_token']);

    if ($decoded) {
        $userId = $decoded->userId;
        // Người dùng đã được xác thực, xử lý logic cho người dùng
    } else {
        echo 'Token không hợp lệ hoặc đã hết hạn.';
        // Có thể chuyển hướng người dùng đến trang đăng nhập
        $extra = "loginAdmin.php";
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri/$extra");
        exit();
    }
} else {
    echo 'Không có token xác thực.';
    $extra = "loginAdmin.php";
    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: http://$host$uri/$extra");
    exit();
    // Có thể chuyển hướng người dùng đến trang đăng nhập
}
?>