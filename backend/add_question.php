<?php
include 'db.php';

$quiz_id = $_POST['quiz_id'];

$sql = "INSERT INTO questions 
(quiz_id, question, option_a, option_b, option_c, option_d, correct_option)
VALUES (
'$quiz_id',
'{$_POST['question']}',
'{$_POST['a']}',
'{$_POST['b']}',
'{$_POST['c']}',
'{$_POST['d']}',
'{$_POST['correct']}'
)";

$conn->query($sql);

// 🔥 Get course_id
$quiz_sql = "SELECT course_id FROM quizzes WHERE id='$quiz_id'";
$res = $conn->query($quiz_sql);
$data = $res->fetch_assoc();

$course_id = $data['course_id'];

// 🔥 Redirect back to same page
header("Location: ../frontend/instructor/create_quiz.php?course_id=$course_id");
exit();
?>