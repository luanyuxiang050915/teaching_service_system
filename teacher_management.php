
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
    $sql = "SELECT teachers.*, departments.department_name
            FROM teachers 
            JOIN departments ON teachers.department_id = departments.department_id
            WHERE teacher_name LIKE '%$search_term%' 
            OR title LIKE '%$search_term%'";
} else {
    $sql = "SELECT teachers.*, departments.department_name
            FROM teachers 
            JOIN departments ON teachers.department_id = departments.department_id";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教师管理</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h2>教师管理</h2>

    <!-- 查询表单 -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search">搜索：</label>
        <input type="text" name="search" value="<?php echo $search_term; ?>" placeholder="输入教师姓名或职称">
        <input type="submit" value="查询">
    </form>

    <!-- 添加教师按钮 -->
    <div align="right"><a href="add_teacher.php" class="add-button">添加教师</a></div>

    <!-- 教师列表 -->
    <table>
        <tr>
            <th>ID</th>
            <th>姓名</th>
            <th>性别</th>
            <th>职称</th>
            <th>联系方式</th>
            <th>所属系部</th>
            <th>年龄</th>
            <th>基本工资</th>
            <th>奖金</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["teacher_id"] . "</td>";
                echo "<td>" . $row["teacher_name"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["contact_info"] . "</td>";
                echo "<td>" . $row["department_name"] . "</td>";
                echo "<td>" . $row["age"] . "</td>";
                echo "<td>" . number_format($row["basic_salary"], 2) . "</td>";
                echo "<td>" . number_format($row["bonus"], 2) . "</td>";
                echo "<td>
                        <a href='edit_teacher.php?id=" . $row["teacher_id"] . "'>修改</a>&ensp;
                        <a href='?delete_teacher=" . $row["teacher_id"] . "' onclick='return confirm(\"确定要删除这位教师吗？\")'>删除</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>暂无教师信息</td></tr>";
        }
        ?>
    </table>
</body>
</html>
