<?php
require_once 'config21.php';
if (isset($_SESSION['userid'])) {
    header('Location: index21.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check_sql = "SELECT * FROM userinfo WHERE username = '$username'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "用户名已存在，请选择其他用户名。";
    } else {
        $insert_sql = "INSERT INTO userinfo (username, password) VALUES ('$username', '$password')";
        if ($conn->query($insert_sql) === true) {
            header('Location: login21.php');
        } else {
            $error = "注册失败:". $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户注册</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>用户注册</h1>
    </header>
    <div class="container">
        <?php if (isset($error)) { echo "<p style='color: red;'>". $error . "</p>"; } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">用户名</label>
            <input type="text" name="username" required>
            <label for="password">密码</label>
            <input type="password" name="password" required>
            <input type="submit" value="注册">
        </form>
        <p>已有账号? <a href="login21.php">登录</a></p>
    </div>
</body>
</html>