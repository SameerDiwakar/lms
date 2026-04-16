<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'instructor') {
    header("Location: ../login.html");
    exit();
}

$course_id = $_GET['course_id'];
?>

<h2>Add Lesson</h2>

<form action="../../backend/add_lesson.php" method="POST">
    
    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">

    <input type="text" name="title" placeholder="Lesson Title" required><br><br>

    <input type="text" name="video_url" placeholder="YouTube Video URL"><br><br>

    <textarea name="content" placeholder="Lesson Content"></textarea><br><br>

    <input type="number" name="lesson_order" placeholder="Lesson Order"><br><br>

    <button type="submit">Add Lesson</button>
</form>