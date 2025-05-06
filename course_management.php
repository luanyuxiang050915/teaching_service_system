
<?php
// 导入配置文件
require_once 'config.php';
if (!isset($_SESSION['userid'])) {
    header('Location: login.php');
    exit;
}

// 处理删除请求
if (isset($_GET['delete_course'])) {
    $course_id = $_GET['delete_course'];
    
    // 首先检查该课程是否有关联的成绩记录
    $check_sql = "SELECT COUNT(*) as count FROM scores WHERE course_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row['count'] > 0) {
        echo "<script>alert('该课程还有关联的成绩记录，无法删除！');</script>";
    } else {
        // 检查是否有关联的授课记录
        $check_teaching_sql = "SELECT COUNT(*) as count FROM teaching WHERE course_id = ?";
        $stmt = $conn->prepare($check_teaching_sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            echo "<script>alert('该课程还有关联的授课记录，无法删除！');</script>";
        } else {
            // 如果没有关联记录，则可以删除
            $delete_sql = "DELETE FROM courses WHERE course_id = ?";
            $stmt = $conn->prepare($delete_sql);
            $stmt->bind_param("i", $course_id);
            
            if ($stmt->execute()) {
                echo "<script>alert('课程删除成功！'); window.location.href='course_management.php';</script>";
            } else {
                echo "<script>alert('删除失败：" . $conn->error . "');</script>";
            }
        }
    }
}

// 查询功能
$search_term = "";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT courses.*, teachers.teacher_name 
            FROM courses 
            LEFT JOIN teachers ON courses.teacher_id = teachers.teacher_id
            WHERE course_name LIKE '%$search_term%' 
            OR teachers.teacher_name LIKE '%$search_term%'";
} else {
    $sql = "SELECT courses.*, teachers.teacher_name 
            FROM courses 
            LEFT JOIN teachers ON courses.teacher_id = teachers.teacher_id";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>课程管理</title>
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
    <h2>课程管理</h2>

    <!-- 查询表单 -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search">搜索：</label>
        <input type="text" name="search" value="<?php echo $search_term; ?>" placeholder="输入课程名称或教师姓名">
        <input type="submit" value="查询">
    </form>

    <!-- 添加课程按钮 -->
    <div align="right"><a href="add_course.php" class="add-button">添加课程</a></div>

    <!-- 课程列表 -->
    <table>
        <tr>
            <th>ID</th>
            <th>课程名称</th>
            <th>授课教师</th>
            <th>学分</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["course_id"] . "</td>";
                echo "<td>" . $row["course_name"] . "</td>";
                echo "<td>" . ($row["teacher_name"] ?? '未分配') . "</td>";
                echo "<td>" . $row["credit"] . "</td>";
                echo "<td>
                        <a href='edit_course.php?id=" . $row["course_id"] . "'>修改</a>&ensp;
                        <a href='?delete_course=" . $row["course_id"] . "' onclick='return confirm(\"确定要删除这门课程吗？\")'>删除</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>暂无课程信息</td></tr>";
        }
        ?>
    </table>
</body>
</html>
