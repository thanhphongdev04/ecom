<?php
session_start();
include 'conn/connect.php';
//Nếu chưa đăng nhập
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "") {
    header("Location:login.php");
    exit();
}

if (!isset($_GET['quantity']) || $_GET['quantity'] <= 0) {
    header('location:index.php?status=failed');
    exit();
}

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $product_id = $_GET['id'];
    $username = $_SESSION['user'];
    $user_id = $_SESSION['user-id'];
    $quantity = $_GET['quantity'];

    //Tìm số lượng sản phẩm của user 
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $quantity = $row['quantity'] + $quantity;

        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        $stmt->execute();
    } else {
        //Nếu không có sản phẩm nào
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        $stmt->execute();
    }
    header('location: index.php?status=success');
    $stmt->close();
} else {
    header('location: index.php?status=failed');
}



/*
if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
    $items = $_SESSION['cart'];
    $items = $items . ',' . $_GET['id'];
    $_SESSION['cart'] = $items;
    header('location: index.php?status=success');
} else {
    if (isset($_GET["id"]) && !empty($_GET["id"])) {
        $item = $_GET['id'];
        $_SESSION['cart'] = $item;
        header('location: index.php?status=success');
    } else {
        header('location: index.php?status=failed');
    }
}
*/