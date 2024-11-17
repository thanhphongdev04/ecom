<?php
session_start();
include 'conn/connect.php';

if (!isset($_SESSION['user']) || $_SESSION['user'] == "" || !isset($_SESSION['user-id']) || $_SESSION['user-id'] == "") {
    header("Location:login.php");
    exit();
}

$user_id = $_SESSION['user-id'];

$checkout_info = $_SESSION['checkout-info'];

$payment_method = $checkout_info['payment-method'];

/*
 * 0: order placed
 * 1: dispatched
 * 2: in progress
 * 3: deliveried
 * -1: cancelled 
 */

$country = $checkout_info['country'];
$first_name = $checkout_info['first-name'];
$last_name = $checkout_info['last-name'];
$company = $checkout_info['company'];
$address = $checkout_info['address'];
$city = $checkout_info['city'];
$state = $checkout_info['state'];
$postcode = $checkout_info['postcode'];
$phone = $checkout_info['phone'];

//update info of user
$sql_get_user = "SELECT * FROM usersmeta WHERE user_id = $user_id";
$res = mysqli_query($conn, $sql_get_user);
if ($res && $res->num_rows > 0) {
    $sql_update_usermeta = "UPDATE usersmeta SET
    country = $country,
    first_name = $first_name,
    last_name = $last_name,
    company = $company,
    address = $address,
    city = $city,
    state = $state,
    postcode = $postcode,
    phone = $phone
    WHERE user_id = $user_id";

    mysqli_query($conn, $sql_update_usermeta);
} else {
    $sql_insert_usersmeat = "INSERT INTO usersmeta(user_id, country, first_name, last_name, company, address, city, state, postcode, phone)
    VALUES ($user_id, '$country', '$first_name', '$last_name', '$company', '$address', '$city', '$state', '$postcode', '$phone')";

    mysqli_query($conn, $sql_insert_usersmeat);
}

//add billing details to database
$products_id = $_SESSION['products-id'];
date_default_timezone_set('Asia/Ho_Chi_Minh');
$current = date('Y-m-d H-i-s');


$sql_add_order = "INSERT INTO orders(payment_date, order_status, payment_method, cart_id) VALUES";

foreach ($checkout_info['carts_id'] as $id) {
    $sql_add_order = $sql_add_order . "('$current', 0, '$payment_method', $id),";
}

$sql_add_order = substr_replace($sql_add_order, ';', -1);

$res = mysqli_query($conn, $sql_add_order);

header('location: myaccount.php');