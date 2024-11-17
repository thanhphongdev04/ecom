<?php session_start();
include "conn/connect.php";

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location:login.php");
    exit();
}

$user_id = $_SESSION['user-id'];

//echo "<pre>" . var_dump($_POST) . "</pre>";
echo var_dump($_POST);


include "template/header.php";
include "template/nav.php";
?>
<div class="container my-4">
    <h1>Chi tiết đơn hàng</h1>
    <table class="table">
        <thead class="bg-warning">
            <tr>
                <th scope="col">Mã đơn hàng</th>
                <th scope="col">Ngày</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Phương thức thanh toán</th>
                <th scope="col">Tổng</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $price_total = 0;
            $quantity_total = 0;
            $sql = 'SELECT orders.id, orders.payment_date, orders.status, orders.payment_method, cart. FROM cart, orders WHERE cart.user_id = ' . $user_id . ' AND cart.id = orders.id';
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th class="text-center" scope="row"><?php echo $row['id'] ?></th>
                    <td class="text-center"><input class="form-check-input" type="checkbox" name="products_id[]"
                            value="<?= $row['id']; ?>"></td>
                    <td><?php echo $row['title'] ?></td>
                    <td class="price">&#36;<?php echo number_format($row['price'], 0, '', '.') ?></td>
                    <td><?php echo $row['quantity'] ?></td>
                    <td><a href="removeFromCart.php?product-id=<?php echo $row['id'] ?>"><button class="btn btn-danger"><i
                                    class="fa-solid fa-trash"></i><span class="mx-3">Xóa</span></button></a></td>
                </tr>
                <?php
                $quantity_total += $row['quantity'];
                $price_total += $row['price'] * $row['quantity'];
            }
            ?>
        </tbody>
    </table>

    <h1>Địa chỉ</h1>
    <p>abc, ấp Sao Hỏa, huyện Mặt Trời, tỉnh MilkyWay, Galaxy</p>

    <h1>Địa chỉ giao hàng</h1>
    <p>Abc</p>
</div>

<?php
include "template/footer.php";
?>