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
        <div class="col-8 py-4">

            <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") { ?>
                <div class="alert alert-danger">
                    <strong>Thông báo:</strong> <?php echo $_SESSION['msg']; ?>
                </div>
                <?php
                $_SESSION['msg'] = "";
            }
            ?>
            <h1>Giỏ hàng</h1>

            <form action="checkout.php" class="view-cart-container" method="POST">
                <table class="table">
                    <thead class="bg-warning">
                        <tr>
                            <th scope="col">S.Number</th>
                            <th scope="col">Check</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
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
                                <td class="text-center"><input class="form-check-input" type="checkbox" name="products_id[]"
                                        value="<?= $row['id']; ?>"></td>
                                <td><?php echo $row['title'] ?></td>
                                <td class="price">&#36;<?php echo number_format($row['price'], 0, '', '.') ?></td>
                                <td><?php echo $row['quantity'] ?></td>
                                <td><a href="removeFromCart.php?product-id=<?php echo $row['id'] ?>"><button
                                            class="btn btn-danger"><i class="fa-solid fa-trash"></i><span
                                                class="mx-3">Xóa</span></button></a></td>
                            </tr>
                            <?php
                            $quantity_total += $row['quantity'];
                            $price_total += $row['price'] * $row['quantity'];
                        }
                        ?>
                    </tbody>
                </table>

                <div class="view-cart-summary position-sticky">
                    <table>
                        <tr class="text-center">
                            <th colspan="2">Tóm tắt giỏ hàng</th>
                        </tr>
                        <tr>
                            <td class="px-3">Tổng số lượng: </td>
                            <?php
                            echo '<td>' . $quantity_total . '</td>';
                            ?>
                        </tr>
                        <tr>
                            <td class="px-3">Tổng tiền: </td>
                            <?php
                            echo '<td class="price"><b>&#36;' . number_format($price_total, 0, '', '.') . '</b></td>';
                            ?>
                        </tr>
                        <tr class="text-center border-top mx-3">
                            <td colspan="2"><button type="submit" class="btn btn-warning px-5">Đến thanh
                                    toán</button></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php
include "template/footer.php";
?>