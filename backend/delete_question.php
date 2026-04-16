<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$question_id = $_GET['id'];

// 🔐 Get quiz_id first
$sql = "SELECT quiz_id FROM questions WHERE id='$question_id'";
$res = $conn->query($sql);

if ($res->num_rows == 0) {
    die("Question not found");
}

$data = $res->fetch_assoc();
$quiz_id = $data['quiz_id'];

// 🔐 Get course_id
$quiz_sql = "SELECT course_id FROM quizzes WHERE id='$quiz_id'";
$res2 = $conn->query($quiz_sql);
$data2 = $res2->fetch_assoc();

$course_id = $data2['course_id'];

// 🗑️ Delete question
$conn->query("DELETE FROM questions WHERE id='$question_id'");

// 🔁 Redirect back
header("Location: ../frontend/instructor/create_quiz.php?course_id=$course_id");
exit();
?>
