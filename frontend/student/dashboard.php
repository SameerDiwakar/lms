<?php
session_start();
include '../../backend/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch enrolled courses
$sql = "SELECT courses.* FROM courses
        JOIN enrollments ON courses.id = enrollments.course_id
        WHERE enrollments.user_id = '$user_id'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <style>
        body { font-family: Arial; }

        .course-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .course-card {
            width: 250px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 10px;
        }

        .course-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div style="background:#333; padding:10px;">
    <a href="../index.php" style="color:white; margin-right:20px;">Home</a>
    <a href="dashboard.php" style="color:white; margin-right:20px;">My Courses</a>
    <a href="../../backend/logout.php" style="color:white;">Logout</a>
</div>
<h2>Welcome, <?php echo $_SESSION['name']; ?></h2>

<h3>My Courses</h3>

<div class="course-container">

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>
<a href="../course.php?id=<?php echo $row['id']; ?>">
        <div class="course-card">
        <img src="../../uploads/<?php echo $row['thumbnail']; ?>">
        <h4><?php echo $row['title']; ?></h4>
        <p><?php echo substr($row['description'], 0, 80); ?>...</p>
    </div>
</a>
<?php
    }
} else {
    echo "You have not enrolled in any courses yet.";
}
?>

</div>

<br>


</body>
</html>