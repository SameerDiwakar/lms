<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    die("Only students can enroll");
}

$user_id = $_SESSION['user_id'];
$course_id = $_POST['course_id'];

// Prevent duplicate enrollment
$check = "SELECT * FROM enrollments WHERE user_id='$user_id' AND course_id='$course_id'";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    echo "Already enrolled";
    exit();
}

// Insert
$sql = "INSERT INTO enrollments (user_id, course_id)
        VALUES ('$user_id', '$course_id')";

if ($conn->query($sql) === TRUE) {
    echo "Enrolled successfully!";
} else {
    echo "Error: " . $conn->error;
}
?>