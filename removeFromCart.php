<?php
session_start();

include('conn/conneect.php');



if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $product_id = $_GET['id'];

    //Tìm số lượng sản phẩm của user 
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $quantity = $row['quantity'] + 1;

        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $stmt->execute();
    } else {
        //Nếu không có sản phẩm nào
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $quantiy_init = 1;
        $stmt->bind_param("iii", $user_id, $product_id, $quantiy_init);
        $stmt->execute();
    }
    header('location: index.php?status=success');
    $stmt->close();
} else {
    header('location: index.php?status=failed');
}

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