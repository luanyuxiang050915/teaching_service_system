<?php
// 导入配置文件
require_once 'config21.php';
if (!isset($_SESSION['userid'])) {
    header('Location: login21.php');
    exit;
}

// 处理删除请求
if (isset($_GET['delete_teaching'])) {
    $teaching_id = $_GET['delete_teaching'];
    
    // 删除授课记录
    $delete_sql = "DELETE FROM teaching WHERE teaching_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $teaching_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('授课记录删除成功！'); window.location.href='teaching_management21.php';</script>";
    } else {
        echo "<script>alert('删除失败：" . $conn->error . "');</script>";
    }
}

// 查询功能
$search_term = "";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT teaching.*, courses.course_name, teachers.teacher_name 
            FROM teaching 
            JOIN courses ON teaching.course_id = courses.course_id
            JOIN teachers ON teaching.teacher_id = teachers.teacher_id
            WHERE courses.course_name LIKE '%$search_term%' 
            OR teachers.teacher_name LIKE '%$search_term%'
            OR teaching.semester LIKE '%$search_term%'";
} else {
    $sql = "SELECT teaching.*, courses.course_name, teachers.teacher_name 
            FROM teaching 
            JOIN courses ON teaching.course_id = courses.course_id
            JOIN teachers ON teaching.teacher_id = teachers.teacher_id";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>授课管理</title>
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
    <h2>授课管理</h2>

    <!-- 查询表单 -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search">搜索：</label>
        <input type="text" name="search" value="<?php echo $search_term; ?>" placeholder="输入课程名称、教师姓名或学期">
        <input type="submit" value="查询">
    </form>

    <!-- 添加授课记录按钮 -->
    <div align="right"><a href="add_teaching.php" class="add-button">添加授课记录</a></div>

    <!-- 授课列表 -->
    <table>
        <tr>
            <th>ID</th>
            <th>课程名称</th>
            <th>教师姓名</th>
            <th>学期</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["teaching_id"] . "</td>";
                echo "<td>" . $row["course_name"] . "</td>";
                echo "<td>" . $row["teacher_name"] . "</td>";
                echo "<td>" . $row["semester"] . "</td>";
                echo "<td>
                        <a href='edit_teaching.php?id=" . $row["teaching_id"] . "'>修改</a>&ensp;
                        <a href='?delete_teaching=" . $row["teaching_id"] . "' onclick='return confirm(\"确定要删除这条授课记录吗？\")'>删除</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>暂无授课信息</td></tr>";
        }
        ?>
    </table>
</body>
</html>