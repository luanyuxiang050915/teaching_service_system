<?php
// 导入配置文件
require_once 'config21.php';
if (!isset($_SESSION['userid'])) {
    header('Location: login21.php');
    exit;
}

// 查询功能
$search_term = "";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT students.*, classes.class_name
            FROM students JOIN classes ON students.class_id = classes.class_id
            WHERE student_name LIKE '%$search_term%' ";
} else {
    $sql = "SELECT students.*, classes.class_name
        FROM students JOIN classes ON students.class_id = classes.class_id";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生管理</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .add-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
        }
        .add-button:hover {
            background-color: #0056d3;
        }
    </style>
</head>
<body>
    <h2>学生管理</h2>

    <!-- 查询表单 -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search"></label>
        <input type="text" name="search" value="<?php echo $search_term; ?>">
        <input type="submit" value="查询">
    </form>

    <!-- 添加学生按钮 -->
    <div align="right"><a href="add_student.php" class="add-button">添加学生</a></div>

    <!-- 学生列表 -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>性别</th>
            <th>出生日期</th>
            <th>联系方式</th>
            <th>班级</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["student_id"] . "</td>";
                echo "<td>" . $row["student_name"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["birth_date"] . "</td>";
                echo "<td>" . $row["contact_info"] . "</td>";
                echo "<td>" . $row["class_name"] . "</td>";
                echo "<td><a href='?delete_student=" . $row["student_id"] . "'>删除</a>&ensp;<a href='edit_student.php?id=" . $row["student_id"] . "'>修改</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>暂无学生信息</td></tr>";
        }
        ?>
</body>
</html>