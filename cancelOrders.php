<?php
session_start();
include "conn/connect.php";
if (isset($_GET['order_id'])) {
    $sql = "UPDATE orders SET order_status = -1 WHERE id = " . $_GET['order_id'];
    mysqli_query($conn, $sql);
}

header('location: myaccount.php');