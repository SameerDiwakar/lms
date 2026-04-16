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
$order_sql = "SELECT MAX(lesson_order) as max_order FROM lessons WHERE course_id='$course_id'";
$order_result = $conn->query($order_sql);
$row = $order_result->fetch_assoc();

$order = ($row['max_order'] ?? 0) + 1;

$sql = "INSERT INTO lessons (course_id, title, video_url, content, lesson_order)
        VALUES ('$course_id', '$title', '$video_url', '$content', '$order')";

if ($conn->query($sql)) {
    header("Location: ../frontend/instructor/dashboard.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>