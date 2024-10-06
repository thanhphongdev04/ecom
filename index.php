<?php
session_start();
include("conn/connect.php");
include("template/header.php");
include("template/nav.php");
?>

<div class="container-fluid">
    <div class="row bg-light">
        <div class="col-1"></div>
        <div class="col-10">
            <?php
            $sql = "SELECT * from products";
            $result = mysqli_query($conn, $sql);
            $count = 0;
            while ($row = mysqli_fetch_array($result)) {
                if ($count == 0) {
                    echo '<div class="row d-flex justify-content-around">'; // Mở hàng mới
                }
                ?>
                <div class="product-container">
                    <div class="thumbnail">
                        <img src="images/<?php echo $row['image'] ?>" alt="Lỗi ảnh...">
                    </div>
                    <div class="info">
                        <h5 class="title"><?php echo $row['title'] ?></h5>
                        <p class=""><?php echo $row['description'] ?></p>
                        <p class="price"><b>Price: <?php echo number_format($row['price']) ?> VND</b></p>
                        <a href="addToCart.php?id=<?php echo $row['id'] ?>"><button class="btn btn-warning"><i
                                    class="fa-solid fa-cart-plus fa-lg"></i> Add to
                                cart</button></a>
                    </div>
                </div>
                <?php
                $count++;

                if ($count == 2) {
                    echo '</div>';
                    $count = 0;
                }
            }
            ?>


        </div>
        <div class="col-1"></div>
    </div>
</div>

<?php
include("template/footer.php");
?>