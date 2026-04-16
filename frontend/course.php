<?php
session_start();
include '../backend/db.php';

// Validate course ID
if (!isset($_GET['id'])) {
    die("Invalid request");
}

$course_id = $_GET['id'];

// Get course
$course_sql = "SELECT * FROM courses WHERE id='$course_id'";
$course_result = $conn->query($course_sql);

if (!$course_result || $course_result->num_rows == 0) {
    die("Course not found");
}

$course = $course_result->fetch_assoc();

// Default: allow access
$is_enrolled = true;

// Check enrollment only for students
if (isset($_SESSION['role']) && $_SESSION['role'] == 'student') {

    $user_id = $_SESSION['user_id'];

    $check = "SELECT * FROM enrollments 
              WHERE user_id='$user_id' AND course_id='$course_id'";

    $res = $conn->query($check);

    $is_enrolled = $res->num_rows > 0;
}

// Get lessons
$lesson_sql = "SELECT * FROM lessons 
               WHERE course_id='$course_id' 
               ORDER BY lesson_order ASC";

$lessons = $conn->query($lesson_sql);

// ✅ Get quiz (FIXED POSITION)
$quiz_sql = "SELECT * FROM quizzes WHERE course_id='$course_id'";
$quiz_result = $conn->query($quiz_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $course['title']; ?></title>

    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .lesson-list li {
            margin-bottom: 10px;
        }

        .enroll-btn {
            margin-top: 15px;
        }

        .locked {
            color: red;
            font-weight: bold;
        }

        .quiz-box {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<h2><?php echo $course['title']; ?></h2>
<p><?php echo $course['description']; ?></p>

<!-- 🔐 Enrollment Button -->
<?php if (!$is_enrolled && isset($_SESSION['role']) && $_SESSION['role'] == 'student') { ?>

    <form action="../backend/enroll.php" method="POST" class="enroll-btn">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <button type="submit">Enroll Now</button>
    </form>

<?php } ?>

<!-- 📖 Lessons Section -->
<h3>Lessons</h3>

<?php if ($is_enrolled) { ?>

    <?php if ($lessons->num_rows > 0) { ?>
        <ul class="lesson-list">
            <?php while($lesson = $lessons->fetch_assoc()) { ?>
                <li>
                    <a href="lesson.php?id=<?php echo $lesson['id']; ?>">
                        <?php echo $lesson['title']; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No lessons added yet.</p>
    <?php } ?>

<?php } else { ?>

    <p class="locked">🔒 Please enroll to access lessons.</p>

<?php } ?>


<!-- 📝 QUIZ SECTION -->
<h3>Quiz</h3>

<div class="quiz-box">

<?php if ($is_enrolled) { ?>

    <?php if ($quiz_result->num_rows > 0) { 
        $quiz = $quiz_result->fetch_assoc();
    ?>

        <a href="quiz.php?id=<?php echo $quiz['id']; ?>">
            📝 Attempt Quiz
        </a>

    <?php } else { ?>
        <p>No quiz available for this course.</p>
    <?php } ?>

<?php } else { ?>

    <p class="locked">🔒 Enroll to access quiz.</p>

<?php } ?>

</div>

<br>
<a href="index.php">← Back to Courses</a>

</body>
</html>