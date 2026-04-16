<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'instructor') {
    header("Location: ../login.html");
    exit();
}
?>

<h2>Instructor Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['name']; ?></p>
<a href="create_course.php">Create New Course</a><br><br>
<a href="../../backend/logout.php">Logout</a>