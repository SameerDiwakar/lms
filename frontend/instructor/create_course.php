<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'instructor') {
    header("Location: ../login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Course</title>
</head>
<body>

<h2>Create Course</h2>

<form action="../../backend/create_course.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
    
    <input type="text" name="title" id="title" placeholder="Course Title"><br><br>
    
    <textarea name="description" id="description" placeholder="Course Description"></textarea><br><br>
    
    <input type="file" name="thumbnail"><br><br>

    <button type="submit">Create Course</button>
</form>

<script>
function validateForm() {
    let title = document.getElementById("title").value;
    let desc = document.getElementById("description").value;

    if (title === "" || desc === "") {
        alert("All fields are required!");
        return false;
    }
    return true;
}
</script>

</body>
</html>