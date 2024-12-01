<?php
session_start();
include("conn/connect.php");
include("template/header.php");
include("template/nav.php");
if (isset($_SESSION['msg']) && $_SESSION['msg'] != "") { ?>
    <div class="w-100 alert my-2 bg-success text-light text-center">
        <i class="fa-solid fa-circle-check"></i>
        <strong>Thông báo:</strong> <?php echo $_SESSION['msg']; ?>
    </div>
    <?php
    $_SESSION['msg'] = "";
}
?>
<div class="container-fluid">
    <div class="row bg-light">
        <div class="col-1"></div>
        <div class="col-10">
            <div class="row d-flex justify-content-around">
                <?php
                $sql = "SELECT * from products";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="product-container">
                        <div class="thumbnail">
                            <img src="images/<?php echo $row['image'] ?>" alt="Lỗi ảnh...">
                        </div>
                        <div class="info">
                            <h5 class="title"><?php echo $row['title'] ?></h5>
                            <p><?php echo $row['description'] ?></p>
                            <h3 class="price"><b>&#36;<?php echo number_format($row['price']) ?></b></h3>
                        </div>
                        <form action="addToCart.php" method="GET">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="number" class="form-control w-50" name="quantity" value="1" min="1" />
                            <div class="action-buttons">
                                <button type="submit" class="btn btn-primary add">
                                    <i class="fa-solid fa-cart-plus fa-lg"></i>
                                </button>
                                <?php
                                if ($isAdmin) {
                                    ?>
                                    <a class="btn btn-warning mx-2 p-3" href="modify-product.php?id=<?= $row['id'] ?>">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <button type="button" class="btn btn-danger p-3" data-toggle="modal"
                                        data-target="#exampleModalCenter" data-productname="<?= $row['title'] ?>"
                                        data-productid="<?= $row['id'] ?>">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <?php
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Xác nhận xóa?</h5>
                <button type="button" class="btn-close btn bg-darkblue text-light" data-dismiss="modal"
                    aria-label="Close">X</button>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa sản phẩm <span class="text-primary" id="product-name"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-3" data-dismiss="modal">Đóng</button>
                <a id="confirm-delete" href="#" class="btn btn-danger p-2">Xóa</a>
            </div>
        </div>
    </div>
</div>

<script>
    $('#exampleModalCenter').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const productName = button.data('productname');
        const productId = button.data('productid');

        // Cập nhật tên sản phẩm trong modal
        const modal = $(this);
        modal.find('.modal-body #product-name').text(productName);

        // Cập nhật link xóa với ID của sản phẩm
        const deleteUrl = "delete-product.php?id=" + productId;
        modal.find('.modal-footer #confirm-delete').attr('href', deleteUrl);
    });

</script>

<?php
include("template/footer.php");
?>