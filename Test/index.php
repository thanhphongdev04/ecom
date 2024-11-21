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
            if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") { ?>
                <div class="alert my-2 alert-warning text-center">
                    <strong>Thông báo:</strong> <?php echo $_SESSION['msg']; ?>
                </div>
                <?php
                $_SESSION['msg'] = "";
            }
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
                        <div>
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <h5 class="title"><?php echo $row['title'] ?></h5>
                            <p><?php echo $row['description'] ?></p>
                            <h3 class="price"><b>&#36;<?php echo number_format($row['price']) ?></b></h3>
                        </div>
                        <form action="addToCart.php" method="GET">
                            <div class="action-container">
                                <div class="top-left">
                                    <input type="number" class="form-control w-25" name="quantity" value="1" min="1" />
                                </div>
                                <div class="mt-3 action-buttons">
                                    <?php
                                    if ($isAdmin) {
                                        ?>
                                        <a class="btn btn-warning p-3" href="modify-product.php?id=<?= $row['id'] ?>">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger mx-2 p-3" onclick="return getConfirm('<?= $row['title'] ?>')"
                                            href="delete-product.php?id=<?= $row['id'] ?>">
                                            <i class="fa-solid fa-trash"></i></a>
                                        <?php
                                    }
                                    ?>
                                    <button type="submit" class="btn btn-primary add">
                                        <i class="fa-solid fa-cart-plus fa-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
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

<script>
    function getConfirm(productName) {
        return confirm('Bạn có chắc muốn xóa sản phẩm\n' + productName);
    }
</script>

<?php
include("template/footer.php");
?>