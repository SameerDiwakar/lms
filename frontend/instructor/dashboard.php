<?php
session_start();
include '../../backend/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'instructor') {
    header("Location: ../login.html");
    exit();
}

$instructor_id = $_SESSION['user_id'];

$sql = "SELECT * FROM courses WHERE instructor_id='$instructor_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Instructor Dashboard</title>

    <style>
        body {
            font-family: Arial;
            margin: 0;
            background: #f5f5f5;
        }

        /* 🔝 Navbar */
        .navbar {
            background: #222;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        .container {
            padding: 20px;
        }

        /* 🧱 Grid */
        .course-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* 📦 Card */
        .course-card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            width: 280px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .course-card h4 {
            margin: 0 0 10px 0;
        }

        /* 🔘 Buttons */
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 3px 2px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 12px;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-danger {
            background: red;
        }

        .btn-success {
            background: green;
        }

        /* 📚 Lesson list */
        .lesson-list {
            max-height: 120px;
            overflow-y: auto;
            margin-top: 10px;
            padding-left: 10px;
            font-size: 13px;
        }

        .lesson-item {
            margin-bottom: 5px;
        }

        .quiz-status {
            margin-top: 5px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<!-- 🔝 Navbar -->
<div class="navbar">
    <div>Instructor Panel</div>
    <div>
        Welcome, <?php echo $_SESSION['name']; ?>
        <a href="../../backend/logout.php">Logout</a>
    </div>
</div>

<div class="container">

<a class="btn btn-success" href="create_course.php">➕ Create New Course</a>

<h3>My Courses</h3>

<div class="course-container">

<?php
while($row = $result->fetch_assoc()) {

    $course_id = $row['id'];

    $lesson_sql = "SELECT * FROM lessons WHERE course_id='$course_id' ORDER BY lesson_order ASC";
    $lesson_result = $conn->query($lesson_sql);

    $quiz_sql = "SELECT * FROM quizzes WHERE course_id='$course_id'";
    $quiz_result = $conn->query($quiz_sql);
?>

<div class="course-card">

    <h4><?php echo $row['title']; ?></h4>

    <!-- Buttons -->
    <a class="btn" href="../course.php?id=<?php echo $course_id; ?>">View</a>
    <a class="btn" href="edit_course.php?id=<?php echo $course_id; ?>">Edit</a>
    <a class="btn" href="add_lesson.php?course_id=<?php echo $course_id; ?>">Add Lesson</a>
    <a class="btn" href="create_quiz.php?course_id=<?php echo $course_id; ?>">Quiz</a>
    <a class="btn btn-danger"
    href="../../backend/delete_course.php?id=<?php echo $course_id; ?>"
    onclick="return confirm('Delete this course? This will remove everything!')">
    Delete Course
    </a>

    <!-- Quiz status -->
    <div class="quiz-status">
        <?php if ($quiz_result->num_rows > 0) { 
            $quiz = $quiz_result->fetch_assoc();
        ?>
            <span style="color:green;">✔ Quiz Created</span><br>
            <a class="btn" href="../quiz.php?id=<?php echo $quiz['id']; ?>">View Quiz</a>
        <?php } else { ?>
            <span style="color:red;">No quiz</span>
        <?php } ?>
    </div>

    <!-- Lessons -->
    <div class="lesson-list">
        <strong>Lessons:</strong><br>

        <?php while($lesson = $lesson_result->fetch_assoc()) { ?>
            <div class="lesson-item">
                <?php echo $lesson['lesson_order'] . ". " . $lesson['title']; ?>

                <a class="btn" href="edit_lesson.php?id=<?php echo $lesson['id']; ?>">Edit</a>
                <a class="btn btn-danger"
                   href="../../backend/delete_lesson.php?id=<?php echo $lesson['id']; ?>"
                   onclick="return confirm('Delete this lesson?')">
                   X
                </a>
            </div>
        <?php } ?>
    </div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>