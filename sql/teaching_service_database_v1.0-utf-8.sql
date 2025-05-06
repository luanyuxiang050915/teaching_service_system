-- 创建数据库
CREATE DATABASE teaching_service_system
CHARACTER SET utf8 
COLLATE utf8_general_ci;

-- 使用数据库
USE teaching_service_system;

-- 创建系部表
CREATE TABLE departments (
    department_id INT AUTO_INCREMENT PRIMARY KEY,
    department_name VARCHAR(100) NOT NULL
);

-- 插入系部数据
INSERT INTO departments (department_name)
VALUES
    ('计算机科学与技术系'),
    ('软件工程系'),
    ('信息管理系'),
    ('网络工程系'),
    ('数据科学系');

-- 创建班级表
CREATE TABLE classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
);

-- 插入班级数据
INSERT INTO classes (class_name, department_id)
VALUES
    ('计科 2001 班', 1),
    ('软工 2002 班', 2),
    ('信管 2003 班', 3),
    ('网工 2004 班', 4),
    ('数据 2005 班', 5);

-- 创建学生表
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(50) NOT NULL,
    gender ENUM('男', '女') NOT NULL,
    birth_date DATE NOT NULL,
    contact_info VARCHAR(100),
    class_id INT,
    FOREIGN KEY (class_id) REFERENCES classes(class_id)
);

-- 插入学生数据
INSERT INTO students (student_name, gender, birth_date, contact_info, class_id)
VALUES
    ('张三', '男', '2000-01-01', '13800138000', 1),
    ('李四', '女', '2001-02-02', '13900139000', 2),
    ('王五', '男', '2002-03-03', '13700137000', 3),
    ('赵六', '女', '2003-04-04', '13600136000', 4),
    ('孙七', '男', '2004-05-05', '13500135000', 5),
    ('周八', '女', '2005-06-06', '13400134000', 1);

-- 创建教师表
CREATE TABLE teachers (
    teacher_id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_name VARCHAR(50) NOT NULL,
    gender ENUM('男', '女') NOT NULL,
    title VARCHAR(50),
    contact_info VARCHAR(100),
    department_id INT,
    age INT,
    basic_salary DECIMAL(8, 2),
    bonus DECIMAL(8, 2),
    FOREIGN KEY (department_id) REFERENCES departments(department_id)
);

-- 插入教师数据
INSERT INTO teachers (teacher_name, gender, title, contact_info, department_id, age, basic_salary, bonus)
VALUES
    ('张老师', '男', '副教授', '18800188000', 1, 38, 8000.00, 2000.00),
    ('李老师', '女', '讲师', '18900189000', 2, 28, 5000.00, 1000.00),
    ('王老师', '男', '教授', '18700187000', 3, 45, 10000.00, 3000.00),
    ('赵老师', '女', '助教', '18600186000', 4, 25, 4000.00, 500.00),
    ('孙老师', '男', '讲师', '18500185000', 5, 30, 5500.00, 1200.00),
    ('周老师', '女', '副教授', '18400184000', 1, 35, 7500.00, 1800.00);

-- 创建课程表
CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    teacher_id INT,
    credit INT NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
);

-- 插入课程数据
INSERT INTO courses (course_name, teacher_id, credit)
VALUES
    ('数据库原理', 1, 3),
    ('编程语言 Python', 2, 4),
    ('数据结构', 3, 3),
    ('计算机网络', 4, 3),
    ('操作系统', 5, 4),
    ('软件工程', 6, 3);

-- 创建成绩表
CREATE TABLE scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    score DECIMAL(5, 2) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

-- 插入成绩数据
INSERT INTO scores (student_id, course_id, score)
VALUES
    (1, 1, 85.00),
    (1, 2, 90.00),
    (2, 1, 78.00),
    (2, 3, 88.00),
    (3, 2, 92.00),
    (3, 4, 75.00),
    (4, 3, 80.00),
    (4, 5, 86.00),
    (5, 4, 72.00),
    (5, 6, 83.00),
    (1, 3, 79.00),
    (1, 4, 82.00),
    (2, 2, 87.00),
    (2, 4, 76.00),
    (3, 1, 84.00),
    (3, 6, 81.00),
    (4, 1, 77.00),
    (4, 2, 89.00),
    (5, 1, 73.00),
    (5, 2, 80.00),
    (6, 1, 86.00),
    (6, 2, 91.00),
    (6, 3, 83.00),
    (6, 4, 78.00),
    (6, 5, 85.00),
    (6, 6, 82.00);

-- 创建授课表
CREATE TABLE teaching (
    teaching_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    teacher_id INT,
    semester VARCHAR(10) NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
);

-- 插入授课表数据
INSERT INTO teaching (course_id, teacher_id, semester)
VALUES
    (1, 1, '2023-2024-1'),
    (2, 2, '2023-2024-1'),
    (3, 3, '2023-2024-1'),
    (4, 4, '2023-2024-1'),
    (5, 5, '2023-2024-1'),
    (6, 6, '2023-2024-1'),
    (1, 1, '2023-2024-2'),
    (2, 2, '2023-2024-2'),
    (3, 3, '2023-2024-2'),
    (4, 4, '2023-2024-2');

-- 创建用户表
CREATE TABLE userinfo (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
); 
