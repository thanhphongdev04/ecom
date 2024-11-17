<?php
session_start();
if (!isset($_POST['total-price'])) {
    header('Location: checkout.php');
}

$price_total = $_POST['total-price'];
$_SESSION['checkout-info'] = $_POST;

?>


<!-- <script src="js/features.js" defer></script> -->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" id="form-autosubmit">
    <input type="hidden" name="business" value="sb-4h51i34013306@business.example.com">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="item_name" value="HoaDon MuaHang">

    <!-- Trị giá của giỏ hàng, vì paypal không hỗ trợ tiền Việt nên phải đổi ra tiền $-->

    <input type="hidden" name="amount" value="<?= $price_total ?>">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="return" value="http://localhost/ECom/success.php">
    <input type="hidden" name="cancel_return" value="http://localhost/ECom/error.php">
</form>