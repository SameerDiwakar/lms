<?php
session_start();
include '../../backend/db.php';

if ($_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$lesson_id = $_GET['id'];

// Get lesson + ensure ownership
$sql = "SELECT lessons.*, courses.instructor_id 
        FROM lessons
        JOIN courses ON lessons.course_id = courses.id
        WHERE lessons.id='$lesson_id'";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Lesson not found");
}

$lesson = $result->fetch_assoc();

// Ownership check
if ($lesson['instructor_id'] != $_SESSION['user_id']) {
    die("Access denied");
}
?>

<h2>Edit Lesson</h2>

<form action="../../backend/update_lesson.php" method="POST">

    <input type="hidden" name="lesson_id" value="<?php echo $lesson['id']; ?>">

    <input type="text" name="title" value="<?php echo $lesson['title']; ?>"><br><br>

    <input type="text" name="video_url" value="<?php echo $lesson['video_url']; ?>"><br><br>

    <textarea name="content"><?php echo $lesson['content']; ?></textarea><br><br>

    <input type="number" name="lesson_order" value="<?php echo $lesson['lesson_order']; ?>"><br><br>

    <button type="submit">Update Lesson</button>
</form>