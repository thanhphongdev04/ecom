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
                    <form class="info" action="addToCart.php" method="GET">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <h5 class="title"><?php echo $row['title'] ?></h5>
                        <p class=""><?php echo $row['description'] ?></p>
                        <p class="price"><b>&#36;<?php echo number_format($row['price']) ?></b></p>
                        <select class="custom-select w-25 mr-3" name="quantity">
                            <option selected value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                        <button type="submit" class="btn btn-warning" onclick="getConfirm()">
                            <i class="fa-solid fa-cart-plus fa-lg"></i>
                            Thêm vào giỏ
                        </button>
                        <?php
                        if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
                            ?>
                            <div class="my-3">
                                <a class="btn btn-warning w-25 mr-3" href="modify-product.php?id=<?= $row['id'] ?>">
                                    <i class="fa-solid fa-pen"></i><span class="ml-1">Sửa đổi</span>
                                </a>
                                <a class="btn btn-danger" onclick="return getConfirm('<?= $row['title'] ?>')"
                                    href="delete-product.php?id=<?= $row['id'] ?>">
                                    <i class="fa-solid fa-trash"></i><span class="ml-2">Xóa sản phẩm</span></a>
                            </div>
                            <?php
                        }
                        ?>
                    </form>

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