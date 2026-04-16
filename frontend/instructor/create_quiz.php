<?php
session_start();
if ($_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$course_id = $_GET['course_id'];
?>

<h2>Create Quiz</h2>

<form action="../../backend/create_quiz.php" method="POST">
    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
    
    <input type="text" name="title" placeholder="Quiz Title" required><br><br>
    
    <button type="submit">Create Quiz</button>
</form>