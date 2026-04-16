<?php
session_start();
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        // 🔥 ROLE-BASED REDIRECT
        if ($user['role'] == 'student') {
            header("Location: ../frontend/student/dashboard.php");
        } elseif ($user['role'] == 'instructor') {
            header("Location: ../frontend/instructor/dashboard.php");
        } else {
            header("Location: ../frontend/admin/dashboard.php");
        }
        exit();

    } else {
        echo "Wrong password";
    }

} else {
    echo "User not found";
}
?>