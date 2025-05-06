<?php
require_once 'config21.php';
if (!isset($_SESSION['userid'])) {
    header('Location: login21.php');
    exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>教学服务系统</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* 自定义表格样式 */
        .system-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .main-table td {
            padding: 30px;
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }
        .main-table td:hover {
            transform: scale(1.03);
            background-color: #f8f9fa;
        }
        .icon {
            font-size: 36px;
            color: #007bff;
            margin-bottom: 15px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .desc {
            color: #6c757d;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .user-info {
            text-align: right;
            margin-bottom: 20px;
        }
        .logout-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #dc3545;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="system-container">
        <div class="user-info">
            欢迎, <?php echo $username; ?> <a href="logout21.php" class="logout-btn">注销</a>
        </div>
        <h1 class="text-center mb-4">教学服务系统</h1>
        <table class="main-table">
            <tr>
                <td>
                    <i class="icon fa-solid fa-user-graduate"></i>
                    <h3 class="title">学生管理</h3>
                    <p class="desc">管理学生基本信息、班级归属等</p>
                    <a href="student_management21.php" class="btn">进入管理</a>
                </td>
                <td>
                    <i class="icon fa-solid fa-chalkboard-user"></i>
                    <h3 class="title">班级管理</h3>
                    <p class="desc">管理班级名称、所属系部等信息</p>
                    <a href="class_management21.php" class="btn">进入管理</a>
                </td>
            </tr>
            <tr>
                <td>
                    <i class="icon fa-solid fa-building-columns"></i>
                    <h3 class="title">系部管理</h3>
                    <p class="desc">管理学校各系部的基本信息</p>
                    <a href="department_management21.php" class="btn">进入管理</a>
                </td>
                <td>
                    <i class="icon fa-solid fa-chalkboard-teacher"></i>
                    <h3 class="title">教师管理</h3>
                    <p class="desc">管理教师信息、职称、薪资等</p>
                    <a href="teacher_management21.php" class="btn">进入管理</a>
                </td>
            </tr>
            <tr>
                <td>
                    <i class="icon fa-solid fa-book-open"></i>
                    <h3 class="title">课程管理</h3>
                    <p class="desc">管理课程名称、授课教师、学分等</p>
                    <a href="course_management21.php" class="btn">进入管理</a>
                </td>
                <td>
                    <i class="icon fa-solid fa-graduation-cap"></i>
                    <!-- <i class="icon fa-soild fa-graduation-cap"></i> -->
                    <h3 class="title">成绩管理</h3>
                    <p class="desc">管理学生成绩及学分记录</p>
                    <a href="score_management21.php" class="btn">进入管理</a>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <i class="icon fa-solid fa-chalkboard"></i>
                    <h3 class="title">授课管理</h3>
                    <p class="desc">管理教师授课信息、学期及课程安排</p>
                    <a href="teaching_management21.php" class="btn">进入管理</a>
                </td>
            </tr>
        </table>
    </div>

    <!-- 引入 Font Awesome 图标库(cloudflare)-->
    <script src="all.min.js"></script>
</body>
</html>