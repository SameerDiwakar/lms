<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into DB
$sql = "INSERT INTO users (name, email, password, role)
        VALUES ('$name', '$email', '$hashed_password', '$role')";

if ($conn->query($sql) === TRUE) {
    echo "Registered successfully!";
} else {
    echo "Error: " . $conn->error;
}
?>