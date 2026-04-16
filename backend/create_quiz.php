<?php
include 'db.php';

$course_id = $_POST['course_id'];
$title = $_POST['title'];

$sql = "INSERT INTO quizzes (course_id, title)
        VALUES ('$course_id', '$title')";

$conn->query($sql);

echo "Quiz created!";
?>