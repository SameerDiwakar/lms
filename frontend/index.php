<?php
include '../backend/db.php';
session_start();

$sql = "SELECT * FROM courses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>LMS Home</title>

    <style>
        body {
            font-family: Arial;
        }

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

<h2>All Courses</h2>

<div class="course-container">

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
?>
<a href="course.php?id=<?php echo $row['id']; ?>">  
    <div class="course-card">
    <img src="../uploads/<?php echo $row['thumbnail']; ?>">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo substr($row['description'], 0, 100); ?>...</p>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'student') { ?>
        
        <form action="../backend/enroll.php" method="POST">
            <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
            <button type="submit">Enroll</button>
        </form>

    <?php } ?>
</a>

</div>

<?php
    }
} else {
    echo "No courses found";
}
?>

</div>

</body>
</html>