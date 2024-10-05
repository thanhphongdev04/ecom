<?php
session_start();
include('conn/connect.php');
include('template/header.php');
include('template/nav.php');

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
            //exit();
        } else {
            $error = "Mật khẩu không đúng.";
        }
    } else {
        $error = "Tên người dùng không tồn tại.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>

<body>
    <div class="container">
        <div style="width: 50%; margin: 0 auto;">
            <h1 class="text-center text-warning">Đăng nhập</h1>
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
                <div>
                    <button type="submit" class="btn btn-warning">Đăng nhập</button>
                    <a href="Register.php" class="btn btn-outline-warning">Đăng ký</a>
                </div>
            </form>
        </div>
    </div>

    <?php include('template/footer.php'); ?>
</body>

</html>