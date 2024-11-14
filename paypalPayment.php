<!DOCTYPE html>

<html>

<head>

    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>Thanh toán qua Paypal</title>

</head>

<body>

    <fieldset>

        <legend>Thanh toán qua cổng PayPal</legend>

        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

            <!-- Nhập địa chỉ email người nhận tiền (người bán) --> business

            <input type="hidden" name="business" value="sb-4h51i34013306@business.example.com">

            <!-- tham số cmd có giá trị xclick chỉ rõ cho paypal biết là người dùng nhất nút thanh toán -->

            <input type="hidden" name="cmd" value="_xclick">

            <!-- Thông tin mua hàng. -->

            <input type="hidden" name="item_name" value="HoaDon MuaHang">

            <!-- Trị giá của giỏ hàng, vì paypal không hỗ trợ tiền Việt nên phải đổi ra tiền $-->

            Nhập số tiền hóa đơn: <input type="number" name="amount" placeholder="Nhập số tiền vào" value="">

            <!--Loại tiền-->

            <input type="hidden" name="currency_code" value="USD">

            <!--Đường link cung cấp cho Paypal biết để sau khi xử lí thành công nó sẽ chuyển về link này-->

            <input type="hidden" name="return" value="http://localhost/ECom/success.html">

            <!--Đường link cung cấp cho Paypal biết để nếu xử lí KHÔNG thành công nó sẽ chuyển về link này--> <input
                type="hidden" name="cancel_return" value="http://localhost/ECom/error.html">

            <input type="submit" name="submit" value="Thanh toán quay Paypal">

        </form>

    </fieldset>

</body>

</html>