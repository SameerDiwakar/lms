<?php
session_start();
include '../backend/db.php';

$course_id = $_GET['id'];

// Get course
$course_sql = "SELECT * FROM courses WHERE id='$course_id'";
$course = $conn->query($course_sql)->fetch_assoc();

// Get lessons
$lesson_sql = "SELECT * FROM lessons WHERE course_id='$course_id' ORDER BY lesson_order ASC";
$lessons = $conn->query($lesson_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $course['title']; ?></title>
</head>
<body>

<h2><?php echo $course['title']; ?></h2>
<p><?php echo $course['description']; ?></p>

<h3>Lessons</h3>

<ul>
<?php
while($lesson = $lessons->fetch_assoc()) {
?>
    <li>
        <a href="lesson.php?id=<?php echo $lesson['id']; ?>">
            <?php echo $lesson['title']; ?>
        </a>
    </li>
<?php } ?>
</ul>

</body>
</html>