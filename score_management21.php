<?php
// 导入配置文件
require_once 'config21.php';
if (!isset($_SESSION['userid'])) {
    header('Location: login21.php');
    exit;
}

// 处理删除请求
if (isset($_GET['delete_score'])) {
    $score_id = $_GET['delete_score'];
    
    // 删除成绩记录
    $delete_sql = "DELETE FROM scores WHERE score_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $score_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('成绩记录删除成功！'); window.location.href='score_management21.php';</script>";
    } else {
        echo "<script>alert('删除失败：" . $conn->error . "');</script>";
    }
}

// 查询功能
$search_term = "";
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT scores.*, students.student_name, courses.course_name 
            FROM scores 
            JOIN students ON scores.student_id = students.student_id
            JOIN courses ON scores.course_id = courses.course_id
            WHERE students.student_name LIKE '%$search_term%' 
            OR courses.course_name LIKE '%$search_term%'
            OR scores.semester LIKE '%$search_term%'";
} else {
    $sql = "SELECT scores.*, students.student_name, courses.course_name 
            FROM scores 
            JOIN students ON scores.student_id = students.student_id
            JOIN courses ON scores.course_id = courses.course_id";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>成绩管理</title>
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
        .score-pass {
            color: green;
        }
        .score-fail {
            color: red;
        }
    </style>
</head>
<body>
    <h2>成绩管理</h2>

    <!-- 查询表单 -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="search">搜索：</label>
        <input type="text" name="search" value="<?php echo $search_term; ?>" placeholder="输入学生姓名、课程名称或学期">
        <input type="submit" value="查询">
    </form>

    <!-- 添加成绩按钮 -->
    <div align="right"><a href="add_score.php" class="add-button">添加成绩</a></div>

    <!-- 成绩列表 -->
    <table>
        <tr>
            <th>ID</th>
            <th>学生姓名</th>
            <th>课程名称</th>
            <th>成绩</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $score_class = ($row["score"] >= 60) ? "score-pass" : "score-fail";
                echo "<tr>";
                echo "<td>" . $row["score_id"] . "</td>";
                echo "<td>" . $row["student_name"] . "</td>";
                echo "<td>" . $row["course_name"] . "</td>";
                echo "<td class='" . $score_class . "'>" . $row["score"] . "</td>";
                echo "<td>
                        <a href='edit_score.php?id=" . $row["score_id"] . "'>修改</a>&ensp;
                        <a href='?delete_score=" . $row["score_id"] . "' onclick='return confirm(\"确定要删除这条成绩记录吗？\")'>删除</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>暂无成绩信息</td></tr>";
        }
        ?>
    </table>
</body>
</html>