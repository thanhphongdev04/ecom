<?php
session_start();

include('conn/conneect.php');

// Lấy ID sản phẩm từ URL
if (isset($_GET['id'])) {
    $product = $_GET['id'];


    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

        $items = explode(",", $_SESSION['cart']);

        // Tìm vị trí của sản phẩm trong mảng
        if (($key = array_search($product, $items)) !== false) {
            // Xóa sản phẩm khỏi mảng
            unset($items[$key]);
        }

        // Cập nhật lại giỏ hàng sau khi xóa sản phẩm
        if (!empty($items)) {
            $_SESSION['cart'] = implode(",", $items); // Chuyển mảng về lại chuỗi
        } else {
            // Nếu không còn sản phẩm nào trong giỏ hàng thì xóa session giỏ hàng
            unset($_SESSION['cart']);
        }
    }
}

header("Location: cart.php");
exit;
