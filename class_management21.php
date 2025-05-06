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
    $sql = "SELECT classes.*, departments.department_name
                FROM classes JOIN departments ON classes.department_id = departments.id
                WHERE class_name LIKE '%$search_term%' ";
} else {
    $sql = "SELECT classes.*, departments.department_name
                FROM classes JOIN departments ON classes.department_id = departments.department_id";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>班级管理</title>
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
    <h2>班级管理</h2>

    <!-- 查询表单 -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search"></label>
        <input type="text" name="search" value="<?php echo $search_term; ?>">
        <input type="submit" value="查询">
    </form>

    <!-- 添加班级按钮 -->
    <div align="right"><a href="add_class.php" class="add-button">添加班级</a></div>

    <!-- 班级列表 -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>班级名称</th>
            <th>所属系部</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["class_id"] . "</td>";
                echo "<td>" . $row["class_name"] . "</td>";
                echo "<td>" . $row["department_name"] . "</td>";
                echo "<td><a href='edit_class.php?id=" . $row["class_id"] . "'>修改</a>&ensp;<a href='?delete_class=" . $row["class_id"] . "'>删除</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>暂无班级信息</td></tr>";
        }
        ?>
    </table>
</body>
</html>