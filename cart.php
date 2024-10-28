<?php session_start();
include "conn/connect.php";
include "template/header.php";
include "template/nav.php";

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location:login.php");
    exit();
}

$user_id = $_SESSION['user-id'];

?>

<div class="container-fluit">
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <h1>View Cart</h1>

            <div class="view-cart-container">
                <table class="table">
                    <thead class="bg-warning">
                        <tr>
                            <th scope="col">S.Number</th>
                            <th scope="col">Item name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Action</th>
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
                                <td><?php echo $row['title'] ?></td>
                                <td class="price"><?php echo number_format($row['price'], 0, '', '.') ?> VND</td>
                                <td><?php echo $row['quantity'] ?></td>
                                <td><a href="removeFromCart.php?product-id=<?php echo $row['id'] ?>"><button
                                            class="btn btn-danger">Remove</button></a></td>
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
                            <th colspan="2">Order summary:</th>
                        </tr>
                        <tr>
                            <td class="px-3">Total quantity: </td>
                            <?php
                            echo '<td>' . $quantity_total . '</td>';
                            ?>
                        </tr>
                        <tr>
                            <td class="px-3">Total price: </td>
                            <?php
                            echo '<td class="price"><b>' . number_format($price_total, 0, '', '.') . ' VND</b></td>';
                            ?>
                        </tr>
                        <tr class="text-center border-top mx-3">
                            <td colspan="2"><button class="btn btn-warning px-5">Checkout</button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php
include "template/footer.php";
?>