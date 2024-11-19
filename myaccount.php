<?php session_start();
include "conn/connect.php";

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location:login.php");
    exit();
}

$user_id = $_SESSION['user-id'];

/*
 * 0: order placed
 * 1: dispatched
 * 2: in progress
 * 3: deliveried
 * -1: cancelled 
 */

function getStatus($status_num)
{
    switch ($status_num) {
        case 0:
            return "Đã đặt hàng";
        case 1:
            return "Đã vận chuyển";
        case 2:
            return "Đang xử lý";
        case 3:
            return "Đã đặt hàng";
        case 4:
            return "Đã giao hàng";
        case -1:
            return "Đã hủy";
    }
}


$orders = null;

$sql_get_order_items = "SELECT orders.id, products.id, products.title, orderitems.product_price, orderitems.quantity 
    FROM orders, orderitems, products 
    WHERE orders.id = orderitems.order_id AND orderitems.product_id = products.id";

$res = mysqli_query($conn, $sql_get_order_items);
while ($row = mysqli_fetch_array($res)) {
    $order_id = $row[0];
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = [];
    }
    if ($row['id'] !== null) {
        $orders[$order_id][] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'product_price' => $row['product_price'],
            'quantity' => $row['quantity']
        ];
    }
}

include "template/header.php";
include "template/nav.php";
?>
<div class="container my-4">
    <h1>Đơn hàng</h1>
    <table class="table">
        <thead class="bg-secondary text-light">
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
            $sql = "SELECT * FROM orders WHERE user_id = $user_id";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <th class="text-center" scope="row">
                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                        <?php echo $row['id'] ?>
                    </th>
                    <td><?= $row['payment_date'] ?></td>
                    <td><?= getStatus($row['order_status']) ?></td>
                    <td><?= $row['payment_method'] ?></td>
                    <td class="price">&#36;<?= number_format($row['total_price'], 0, '', '.') ?></td>
                    <td>
                        <button type="button" class="btn btn-primary view-order" data-toggle="modal"
                            data-target="#detailModal" data-isclick="false"
                            data-orders="<?= htmlspecialchars(json_encode($orders[$row['id']]), ENT_QUOTES, 'UTF-8') ?>">
                            <i class="fa-solid fa-eye"></i><span class="mx-3">Xem</span></span>
                        </button>
                        <?php
                        if ($row['payment_method'] != 'paypal' && $row['order_status'] != -1) { ?>
                            <a href="cancelOrders.php?order-id=<?= $row['id'] ?>" class="btn btn-danger">
                                <i class="fa-solid fa-xmark"></i><span class="mx-3">Hủy</span>
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <!-- <p>abc, ấp Sao Hỏa, huyện Mặt Trời, tỉnh MilkyWay, Galaxy</p> -->
    <h1>Địa chỉ</h1>
    <?php
    $sql = "SELECT * FROM usersmeta WHERE user_id = $user_id";
    $res = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($res)) {
        echo "<p>" . $row['address'] . "</p>";
    }
    ?>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Chi tiết</h5>
                <button type="button" class="btn-close btn bg-darkblue text-light" data-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <table class="table" id="product_table">
                    <tr>
                        <th>Mã SP</th>
                        <th>Tên SP</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-25" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script defer>
    $('#detailModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);

        const products = button.data('orders');

        const productTable = $('#product_table');

        products.forEach(product => {
            const newRow = $('<tr></tr>').addClass('product-row');
            newRow.append($('<td>').text(product['id']));
            newRow.append($('<td>').text(product['title']));
            newRow.append($('<td>').text(product['quantity']));
            newRow.append($('<td>').append($('<trong>').addClass('price').text('$' + product['product_price'])));

            productTable.append(newRow);
        });
    });

    // Sự kiện khi người dùng nhấn nút đóng (nút "X" hoặc nút "Đóng")
    $('.btn-close, .btn-secondary').on('click', function () {
        $('.product-row').remove();
    });

</script>

<?php
include "template/footer.php";
?>