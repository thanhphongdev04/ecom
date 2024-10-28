<?php
session_start();
include('conn/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flag = false;
    $u = $_POST['username'];
    $p = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu
    $e = $_POST['email'];

    // Sử dụng prepared statements để ngăn chặn SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $u, $e);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $mess = "Tên người dùng hoặc email đã tồn tại";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, type) VALUES (?, ?, ?, 'adr')");
        $stmt->bind_param("sss", $u, $p, $e);
        if ($stmt->execute()) {
            $mess = "Đăng ký thành công";
            $flag = true;
        } else {
            $mess = "Đăng ký thất bại";
        }
    }

    $stmt->close();
}


include('template/header.php');
include('template/nav.php');
?>

<script>
    function validatePassword() {
        var password = document.getElementById("password").value;
        var repassword = document.getElementById("repassword").value;
        var message = document.getElementById("error-message");

        if (password === repassword) {
            message.textContent = ""; // Xóa thông báo lỗi
            return true; // Cho phép gửi biểu mẫu
        } else {
            message.textContent = "Mật khẩu không khớp!"; // Hiển thị thông báo lỗi
            return false; // Ngăn gửi biểu mẫu
        }
    }
</script>


<div class="container d-flex my-3">
    <div class="w-50 p-5 border border-dark">
        <h1 class="text-warning text-center">Đăng ký</h1>
        <form action="" method="POST" onsubmit="return validatePassword()">
            <div class="form-group">
                <label for="username">Tên người dùng:</label>
                <input type="text" class="form-control" placeholder="Nhập tên người dùng" name="username" id="username"
                    required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" placeholder="Nhập email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password" id="password"
                    required>
            </div>
            <div class="form-group">
                <label for="repassword">Nhập lại mật khẩu:</label>
                <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name="repassword"
                    id="repassword" required>
                <span id="error-message" class="error" style="color: red;"></span>

                <?php if (isset($mess) && $mess != ""): ?>
                    <div class="alert alert-<?php echo $flag ? "success" : "danger"; ?> mt-2">
                        <strong>Thông báo</strong> <?php echo $mess; ?>.
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-warning">Đăng ký</button>
            </div>
        </form>
    </div>
    <div class="w-50 d-flex flex-column align-items-center justify-content-center bg-dark text-light rounded-end-2">
        <img class="icon" src="images/bmazon-logo.jpg">
        <h4>Chào mừng bạn đến đăng ký</h4>
        <p>Đã có tài khoản?</p>
        <a href="login.php" class="btn btn-outline-warning">Đăng nhập</a>
    </div>
</div>

<?php include('template/footer.php'); ?>