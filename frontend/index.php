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
            padding: 20px;
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
            transition: 0.2s;
        }

        .course-card:hover {
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .course-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        a {
            text-decoration: none;
            color: black;
        }

        .enrolled {
            color: green;
            font-weight: bold;
        }

        .btn {
            margin-top: 8px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>All Courses</h2>

<div class="course-container">

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        $user_id = $_SESSION['user_id'] ?? 0;
        $is_enrolled = false;

        if ($user_id) {
            $check = "SELECT * FROM enrollments 
                      WHERE user_id='$user_id' AND course_id='{$row['id']}'";

            $res = $conn->query($check);
            $is_enrolled = $res->num_rows > 0;
        }
?>

<div class="course-card">

    <!-- Clickable content -->
    <a href="course.php?id=<?php echo $row['id']; ?>">
        <img src="../uploads/<?php echo $row['thumbnail']; ?>">
        <h3><?php echo $row['title']; ?></h3>
        <p><?php echo substr($row['description'], 0, 100); ?>...</p>
    </a>

    <!-- Student actions -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'student') { ?>

        <?php if ($is_enrolled) { ?>
            <p class="enrolled">✔ Enrolled</p>
        <?php } else { ?>
            <form action="../backend/enroll.php" method="POST">
                <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                <button class="btn" type="submit">Enroll</button>
            </form>
        <?php } ?>

    <?php } ?>

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