<?php
session_start();
include '../../backend/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'instructor') {
    header("Location: ../login.html");
    exit();
}

$instructor_id = $_SESSION['user_id'];

// Fetch instructor's courses
$sql = "SELECT * FROM courses WHERE instructor_id='$instructor_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Instructor Dashboard</title>

    <style>
        .course-card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 10px;
            width: 250px;
        }
    </style>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['name']; ?></h2>

<a href="create_course.php">➕ Create New Course</a>

<h3>My Courses</h3>

<div style="display:flex; flex-wrap:wrap;">

<?php
while($row = $result->fetch_assoc()) {
?>

<div class="course-card">
    <h4><?php echo $row['title']; ?></h4>

    <a href="edit_course.php?id=<?php echo $row['id']; ?>">Edit Course</a><br>
    <a href="add_lesson.php?course_id=<?php echo $row['id']; ?>">Add Lesson</a><br>

    <strong>Lessons:</strong><br>

    <?php
    $course_id = $row['id'];
    $lesson_sql = "SELECT * FROM lessons WHERE course_id='$course_id'";
    $lesson_result = $conn->query($lesson_sql);

    while($lesson = $lesson_result->fetch_assoc()) {
    ?>
        <div style="margin-left:10px;">
            • <?php echo $lesson['title']; ?>
            <a href="edit_lesson.php?id=<?php echo $lesson['id']; ?>">Edit</a>
            <a href="../../backend/delete_lesson.php?id=<?php echo $lesson['id']; ?>" 
               onclick="return confirm('Delete this lesson?')">Delete</a>
        </div>
    <?php } ?>
</div>

<?php } ?>

</div>

<br>
<a href="../../backend/logout.php">Logout</a>

</body>
</html>