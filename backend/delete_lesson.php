<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$lesson_id = $_GET['id'];

// 🔐 Ownership check
$sql = "SELECT courses.instructor_id 
        FROM lessons
        JOIN courses ON lessons.course_id = courses.id
        WHERE lessons.id='$lesson_id'";

$result = $conn->query($sql);
$data = $result->fetch_assoc();

if ($data['instructor_id'] != $_SESSION['user_id']) {
    die("Access denied");
}

// Delete
$conn->query("DELETE FROM lessons WHERE id='$lesson_id'");

header("Location: ../frontend/instructor/dashboard.php");
exit();
?>