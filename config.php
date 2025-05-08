
<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'teaching_service_system';

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 设置字符编码为 utf8
$conn->set_charset('utf8');

// 检查连接是否成功
if ($conn->connect_error) {
    die('连接失败：' . $conn->connect_error);
}
session_start();
?>
