<?php
session_start();
include '../../backend/db.php';

if ($_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$course_id = $_GET['id'];
$instructor_id = $_SESSION['user_id'];

// Get course (ONLY if owned by instructor)
$sql = "SELECT * FROM courses 
        WHERE id='$course_id' AND instructor_id='$instructor_id'";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Course not found or access denied");
}

$course = $result->fetch_assoc();
?>

<h2>Edit Course</h2>

<form action="../../backend/update_course.php" method="POST">
    
    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">

    <input type="text" name="title" value="<?php echo $course['title']; ?>"><br><br>

    <textarea name="description"><?php echo $course['description']; ?></textarea><br><br>

    <button type="submit">Update Course</button>
</form>