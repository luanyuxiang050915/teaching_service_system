<?php
require_once 'config21.php';
if (isset($_SESSION['userid'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    // echo $username;
    $password = $_POST['password'];
    // echo $password;

    $sql = "SELECT * FROM userinfo WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result === false) {
        die("查询失败: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userid'] = $row['userid'];
        $_SESSION['username'] = $row['username'];
        // var_dump($_SESSION);
        header('Location: index.php');
    } else {
        $error ="用户名或密码错误，请重试。";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户登录</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>用户登录</h1>
    </header>
    <div class="container">
        <?php if (isset($error)) { echo "<p style='color: red;'>". $error ."</p>"; } ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">用户名:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">密码:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="登录">
        </form>
        <p>还没有账号? <a href="register21.php">注册</a></p>
    </div>
</body>
</html>