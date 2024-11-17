<?php
session_start();
include 'conn/connect.php';
if (!isset($_GET['id'])) {
    header('location: index.php');
    exit();
}

echo "<pre>";
var_dump($_POST);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = 'images/';
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];

        $destination = $uploadDir . $fileName;

        move_uploaded_file($fileTmpPath, $destination);
    }

    $id = $_POST['id'];
    $catid = $_POST['catid'];
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $_POST['name-image'];
    $date_added = $_POST['date_added'] . ' 00:00:00';
    $status = $_POST['status'];

    $sql = "UPDATE products SET 
            catid = $catid,
            title = '$title',   
            price = $price,
            description = '$description',
            image = '$image',
            date_added = '$date_added',
            status = $status
            WHERE id = $id
    ";
    mysqli_query($conn, $sql);
    if ($conn->affected_rows > 0)
        $_SESSION['msg'] = 'Sửa đổi thành công!';
    else
        $_SESSION['msg'] = 'Sửa đổi thất bại!';
    header('location: index.php');
}


include("template/header.php");
include("template/nav.php");
?>
<form action="" method="POST" class="container my-5" enctype="multipart/form-data">
    <h1 class="text-warning">Sửa sản phẩm</h1>
    <label class="my-2">Loại</label>
    <select class="form-control" name="catid">
        <?php
        $sql_get_categories = "SELECT * FROM category";
        echo $sql_get_categories;
        $result = mysqli_query($conn, $sql_get_categories);
        while ($row_cat = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row_cat['id'] . "'>" . $row_cat['name'] . "</option>";
        }
        ?>
    </select>
    <?php
    $sql = "SELECT * FROM products WHERE id = " . $_GET['id'];
    $res = mysqli_query($conn, $sql);
    $date_added = "";
    if ($row = mysqli_fetch_assoc($res)) {
        ?>
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <label class="my-2">Tiêu đề</label>
        <input class="form-control" type="text" name="title" value="<?= $row['title'] ?>">

        <label class="my-2">Giá</label>
        <input class="form-control" type="text" name="price" value="<?= $row['price'] ?>">

        <label class="my-2">Mô tả</label>
        <input class="form-control" type="text" name="description" value="<?= $row['description'] ?>">

        <label class="my-2">Hình ảnh</label>
        <input class="form-control p-1" type="file" name="file" id="file">
        <input type="hidden" name="name-image" id="name-image" value="<?= $row['image'] ?>">

        <div class="w-48 d-inline-block">
            <label class="my-2">Ngày thêm</label>
            <input class="form-control" type="date" name="date_added" id="date" value="<?= $row['date_added'] ?>">
        </div>

        <div class="w-50 d-inline-block">
            <label class="my-2">Trạng thái</label>
            <input class="form-control" type="text" name="status" value="<?= $row['status'] ?>">
        </div>

        <div class="text-center my-3">
            <button class="btn btn-warning my-2 text-center w-25">
                <i class="fa-solid fa-floppy-disk"></i>
                <span class="px-2">Lưu</span>
            </button>
        </div>
        <?php
        $date_added = $row['date_added'];
    }
    ?>
</form>
<script>
    document.getElementById('file').addEventListener('change', function (event) {
        const fileInput = event.target;
        const fileName = document.getElementById('name-image');

        if (fileInput.files.length > 0) {
            fileName.value = fileInput.files[0].name;
        }
    });

    const datetime = '<?= $date_added ?>';

    const datePart = datetime.split(' ')[0];

    document.getElementById('date').value = datePart;
</script>


<?php
include("template/footer.php");
?>