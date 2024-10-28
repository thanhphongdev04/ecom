<?php
session_start();
include('conn/connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sử dụng prepared statements để ngăn chặn SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?"); //username có tồn tại?
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['user-id'] = $user['id'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Mật khẩu không đúng.";
        }
    } else {
        $error = "Tên người dùng không tồn tại.";
    }

    $stmt->close();
}

include('template/header.php');
include('template/nav.php');

?>

<html lang="vi">

<head>
    <title>Đăng nhập</title>
</head>

<body>
    <div class="container d-flex my-3">
        <div class="w-50 p-5 border border-warning">
            <h2 class="text-warning mb-3">Đăng nhập</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <strong>Thông báo:</strong> <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Tên người dùng:</label>
                    <input type="text" class="form-control" placeholder="Nhập tên người dùng" name="username"
                        id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" class="form-control" placeholder="Nhập mật khẩu" name="password"
                        id="password" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-warning">Đăng nhập</button>
                </div>
            </form>
        </div>

        <div class="w-50 d-flex flex-column align-items-center justify-content-center bg-warning rounded-end-2">
            <img class="icon" src="images/bmazon-logo.jpg">
            <h4>Chào mừng bạn đến đăng nhập</h4>
            <p>Chưa có tài khoản?</p>
            <a href="Register.php" class="btn btn-outline-dark">Đăng kí</a>
        </div>

    </div>

    <?php include('template/footer.php'); ?>
</body>

</html>