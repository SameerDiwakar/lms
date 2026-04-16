<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$title = $_POST['title'];
$description = $_POST['description'];
$instructor_id = $_SESSION['user_id'];

// Handle file upload
$thumbnail = $_FILES['thumbnail']['name'];
$temp = $_FILES['thumbnail']['tmp_name'];

$upload_path = "../uploads/" . $thumbnail;

move_uploaded_file($temp, $upload_path);

// Insert into DB
$sql = "INSERT INTO courses (title, description, instructor_id, thumbnail)
        VALUES ('$title', '$description', '$instructor_id', '$thumbnail')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../frontend/instructor/dashboard.php?quiz_id=$quiz_id");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>