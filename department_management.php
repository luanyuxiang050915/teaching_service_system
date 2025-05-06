
<?php
// 导入配置文件
require_once 'config.php';
if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}

// 查询功能
$search_term = "";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT * FROM departments WHERE department_name LIKE '%$search_term%'";
} else {
    $sql = "SELECT * FROM departments";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>系部管理</title>
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
    <h2>系部管理</h2>

    <!-- 查询表单 -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search"></label>
        <input type="text" name="search" value="<?php echo $search_term; ?>">
        <input type="submit" value="查询">
    </form>

    <!-- 添加系部按钮 -->
    <div align="right"><a href="add_department.php" class="add-button">添加系部</a></div>

    <!-- 系部列表 -->
    <table border="1">
        <tr>
            <th>ID</th>
            <th>系部名称</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["department_id"] . "</td>";
                echo "<td>" . $row["department_name"] . "</td>";
                echo "<td><a href='edit_department.php?id=" . $row["department_id"] . "'>编辑</a> | <a href='delete_department.php?id=" . $row["department_id"] . "'>删除</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>暂无系部信息</td></tr>";
        }
        ?>
    </table>
</body>
</html>
