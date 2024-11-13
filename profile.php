<?php
session_start();
include('conn/connect.php');

if (isset($_SESSION['user']) && isset($_SESSION['user-id'])) {
    $sql = "SELECT * FROM users WHERE id = " . $_SESSION['user-id'];
    $res = mysqli_query($conn, $sql);
    $user = $res->fetch_assoc();
} else {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $flag = false;
    $id = $user['id'];

    $sql = "SELECT * FROM users WHERE id != $id AND email = '$email'";
    $res = mysqli_query($conn, $sql);
    if ($res->num_rows > 0) {
        $mess = "Email đã tồn tại!";
    } else if (password_verify($old_password, $user['password'])) {
        if (!empty($new_password)) {
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        } else {
            $new_hashed_password = $user['password'];
        }

        $sql = "UPDATE users SET email = '$email', password = '$new_hashed_password' WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        if ($result = mysqli_query($conn, $sql)) {
            $mess = "Cập nhật thành công";
            $flag = true;
        } else {
            $mess = "Cập nhật thất bại";
        }
    } else {
        $mess = "Mật khẩu không chính xác!";
    }
}


include('template/header.php');
include('template/nav.php');
?>


<div class="container d-flex justify-content-center my-3">
    <div class="w-75 p-5 border border-dark rounded">
        <h1 class="text-warning text-center"><i class="fa-solid fa-pen text-warning"></i><span class="mx-2">Chỉnh sửa
                thông tin</span></h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Tên người dùng:</label>
                <input type="text" class="form-control" placeholder="Nhập tên người dùng" name="username" id="username"
                    required value="<?= $user['username']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" placeholder="Nhập email" name="email" id="email" required
                    value="<?= $user['email']; ?>">
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu cũ:</label>
                <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="old_password"
                    id="old_password" required>
            </div>
            <div class="form-group">
                <label for="repassword">Mật khẩu mới:</label>
                <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="new_password"
                    id="new_password">
                <span id="error-message" class="error" style="color: red;"></span>

                <?php if (isset($mess) && $mess != ""): ?>
                    <div class="alert alert-<?php echo $flag ? "success" : "danger"; ?> mt-2">
                        <strong>Thông báo</strong> <?php echo $mess; ?>.
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning w-25"><i class="fa-solid fa-floppy-disk"></i><span
                        class="px-2">Lưu</span></button>
            </div>
        </form>
    </div>
</div>

<?php
include('template/footer.php');

?>