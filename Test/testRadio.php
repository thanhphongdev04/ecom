<form action="testRadio.php" method="post">
    <h2 class="text-warning">Phương thức thanh toán</h2>
    <div class="view-cart-container">
        <table class="table p-2">
            <tbody>
                <tr class="border-top-0">
                    <td class="w-50">
                        <input type="radio" checked name="payment-method" id="cash" value="cash">
                        <label class="mx-2" for="cash">Tiền mặt</label>
                        <p>Make your payment directly into our bank account. Plese use your Order ID as the
                            payment reference. Your order won't be shipped until the funds have cleared in
                            your
                            account</p>
                    </td>
                    <td>
                        <input type="radio" name="payment-method" id="paypal" value="paypal">
                        <label class="mx-2" for="paypal">Paypol</label>
                        <p>Pay via PayPal. You can pay with your credit and if you don't have a PayPol
                            account
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>




    <div class="d-flex  my-3">
        <input type="checkbox" id="terms" name="agree">
        <label class="mx-2" for="terms">Tôi đã đọc và chấp nhận tất cả điều khoản</label>
    </div>

    <input class="btn btn-warning" type="submit" name="submit" value="Thanh toán">
</form>

<?php
echo $_POST["payment-method"];
echo "<br>Is agree: " . $_POST['agree'];
