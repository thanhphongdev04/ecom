<?php session_start();
include("conn/connect.php"); ?>

<?php
include "template/header.php";
include "template/nav.php";

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location:login.php");
    return;
}

$user_id = $_SESSION['user_id'];

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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
                            $id_items = explode(",", $_SESSION['cart']);
                            foreach ($id_items as $id) {
                                ?>
                                <tr>
                                    <?php
                                    $sql = "select * from products where id = " . $id;
                                    $result = mysqli_query($conn, $sql);
                                    if ($row = mysqli_fetch_array($result)) {
                                        ?>
                                        <th class="text-center" scope="row"><?php echo $row['id'] ?></th>
                                        <td><?php echo $row['title'] ?></td>
                                        <td><?php echo $row['price'] ?></td>
                                        <td><a href=""><button class="btn btn-danger">Remove</button></a></td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>
                            <th scope="row">Total</th>
                            <td></td>
                            <td></td>
                            <td><button class="btn btn-warning text-dark">Checkout</button></td>
                        </tr>
                    </tbody>
                </table>

                <div class="view-cart-total position-sticky">

                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</div>
<?php
include "template/footer.php";
?>