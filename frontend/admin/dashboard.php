<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.html");
    exit();
}
?>

<h2>Admin Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['name']; ?></p>

<a href="../../backend/logout.php">Logout</a>