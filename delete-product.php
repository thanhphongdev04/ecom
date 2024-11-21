<?php
session_start();
include "conn/connect.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id = $id";

    mysqli_query($conn, $sql);
    if ($conn->affected_rows > 0)
        $_SESSION['msg'] = 'Đã xóa thành công!';
    else
        $_SESSION['msg'] = 'Xóa thất bại!';
} else {
    $_SESSION['msg'] = 'Có lỗi xảy ra!';
}

header('location: index.php');