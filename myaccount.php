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
            <form action="cancelOrders.php" method="GET">
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
                            <button type="submit" class="btn btn-danger">
                                <i class="fa-solid fa-xmark"></i><span class="mx-3">Hủy</span>
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </form>
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

<?php
include "template/footer.php";
?>