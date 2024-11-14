<?php session_start();
include "conn/connect.php";

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location:login.php");
    exit();
}

include "template/header.php";
include "template/nav.php";
$user_id = $_SESSION['user-id'];

?>

<div class="container-fluit">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h2 class="text-warning">Chi tiết thanh toán</h2>
            <div class="container d-flex justify-content-center">
                <table class="table w-75">
                    <tr>
                        <td colspan="3">
                            <label>Quốc gia</label>
                            <select name="country" class="form-control">
                                <option value="">Việt Nam</option>
                                <option value="">Mỹ</option>
                                <option value="">Đức</option>
                            </select>
                        </td>
                    </tr>
                    <tr scope="row">
                        <td colspan="3" class="w-100">
                            <div class="d-inline-block w-48">
                                <label>Họ</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="d-inline-block w-50">
                                <label>Tên</label>
                                <input type="text" class="form-control" name="" id="">
                            </div>
                        </td>
                    </tr>
                    <tr scope="row">
                        <td colspan="3">
                            <label>
                                Công ty</label>
                            <input type=" text" class="form-control">
                        </td>
                    </tr>
                    <tr scope="row">
                        <td colspan="3">
                            <label>
                                Địa chỉ</label>
                            <input type="text" class="form-control">
                        </td>
                    </tr>
                    <tr scope="row">
                        <td>
                            <label>
                                Thành phố</label>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <label>
                                Trạng thái</label>
                            <input type="text" class="form-control">
                        </td>
                        <td>
                            <label>Mã bưu chính</label>
                            <input type="text" class="form-control">
                        </td>
                    </tr>
                    <tr scope="row">
                        <td colspan="3">
                            <label>
                                Số điện thoại</label>
                            <input type="text" class="form-control">
                        </td>
                    </tr>
                </table>
            </div>

            <h2 class="text-warning">Chi tiết đặt hàng</h2>

            <div class="view-cart-container">
                <table class="table">
                    <tbody>
                        <?php
                        $price_total = 0;
                        $quantity_total = 0;
                        $sql = 'SELECT products.id, products.title, products.price, cart.quantity FROM cart, products WHERE user_id = ' . $user_id . ' AND products.id = cart.product_id';
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr>
                                <th class="text-center" scope="row"><?php echo $row['id'] ?></th>
                                <td><?php echo $row['title'] ?></td>
                                <td class="price">&#36;<?php echo number_format($row['price'], 0, '', '.') ?></td>
                                <td><?php echo $row['quantity'] ?></td>
                                <td class="price">
                                    &#36;<?php echo number_format(($row['price'] * $row['quantity']), 0, '', '.') ?>
                                </td>
                            </tr>
                            <?php
                            $quantity_total += $row['quantity'];
                            $price_total += $row['price'] * $row['quantity'];
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <h2 class="text-warning">Đơn hàng của bạn</h2>
            <div class="view-cart-container">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Tổng số lượng:</td>
                            <td><?= $quantity_total ?></td>
                        </tr>
                        <tr>
                            <td>Vận chuyển và xử lý</td>
                            <td>Free</td>
                        </tr>
                        <tr>
                            <td>Tổng số tiền:</td>
                            <td class="price">&#36;<?php echo number_format($price_total, 0, '', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="text-warning">Phương thức thanh toán</h2>
            <div class="view-cart-container">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><input type="radio" checked name="payment-method" id="cash"><label class="mx-2"
                                    for="cash">Tiền
                                    mặt</label>
                                <p>Make your payment directly into our bank account. Plese use your Order ID as the
                                    payment reference. Your order won't be shipped until the funds have cleared in your
                                    account</p>
                            </td>
                            <td><input type="radio" name="payment-method" id="paypol"><label class="mx-2"
                                    for="paypol">Paypol</label>
                                <p>Pay via PayPal. You can pay with your credit and if you don't have a PayPol account
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <input type="checkbox" name="payment-method" id="terms"><label class="mx-2" for="terms">Tôi đã đọc và chấp
                nhận tất cả điều khoản</label>

            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="business" value="sb-4h51i34013306@business.example.com">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="item_name" value="HoaDon MuaHang">

                <!-- Trị giá của giỏ hàng, vì paypal không hỗ trợ tiền Việt nên phải đổi ra tiền $-->

                <input type="hidden" name="amount" value="<?= $price_total ?>">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="return" value="http://localhost/ECom/success.html">
                <input type="hidden" name="cancel_return" value="http://localhost/ECom/error.html">

                <input class="btn btn-warning" type="submit" name="submit" value="Thanh toán">
            </form>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php
include "template/footer.php";
?>