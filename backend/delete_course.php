<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$course_id = $_GET['id'];
$instructor_id = $_SESSION['user_id'];

// 🔐 Check ownership
$check = "SELECT * FROM courses 
          WHERE id='$course_id' AND instructor_id='$instructor_id'";

$res = $conn->query($check);

if ($res->num_rows == 0) {
    die("Unauthorized");
}

// 🧠 Get quiz id (if exists)
$quiz_sql = "SELECT id FROM quizzes WHERE course_id='$course_id'";
$quiz_res = $conn->query($quiz_sql);

if ($quiz_res->num_rows > 0) {
    $quiz = $quiz_res->fetch_assoc();
    $quiz_id = $quiz['id'];

    // Delete questions first
    $conn->query("DELETE FROM questions WHERE quiz_id='$quiz_id'");

    // Delete quiz
    $conn->query("DELETE FROM quizzes WHERE id='$quiz_id'");
}

// 🧱 Delete lessons
$conn->query("DELETE FROM lessons WHERE course_id='$course_id'");

// 👨‍🎓 Delete enrollments
$conn->query("DELETE FROM enrollments WHERE course_id='$course_id'");

// 🗑️ Delete course
$conn->query("DELETE FROM courses WHERE id='$course_id'");

// 🔁 Redirect back
header("Location: ../frontend/instructor/dashboard.php");
exit();
?>