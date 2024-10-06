<?php
session_start();

include('conn/connect.php');

if (!isset($_SESSION['user-id']) || $_SESSION['user-id'] == "") {
    header("Location:login.php");
    return;
}

if (isset($_GET["product-id"]) && !empty($_GET["product-id"])) {
    $product_id = $_GET['product-id'];
    $user_id = $_SESSION['user-id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();
}
header('location: cart.php');

/*
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
*/