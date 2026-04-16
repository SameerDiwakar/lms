<?php
session_start();
include 'db.php';

if ($_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$course_id = $_POST['course_id'];
$title = $_POST['title'];
$video_url = $_POST['video_url'];
$content = $_POST['content'];
$order = $_POST['lesson_order'];

$sql = "INSERT INTO lessons (course_id, title, video_url, content, lesson_order)
        VALUES ('$course_id', '$title', '$video_url', '$content', '$order')";

if ($conn->query($sql)) {
    echo "Lesson added!";
} else {
    echo "Error: " . $conn->error;
}
?>