<?php
session_start();
include '../../backend/db.php';

if ($_SESSION['role'] != 'instructor') {
    die("Access denied");
}

$course_id = $_GET['course_id'];

// Check if quiz exists
$check = "SELECT * FROM quizzes WHERE course_id='$course_id'";
$res = $conn->query($check);

$quiz = null;
$questions = null;

if ($res->num_rows > 0) {
    $quiz = $res->fetch_assoc();

    // Fetch questions
    $q_sql = "SELECT * FROM questions WHERE quiz_id='{$quiz['id']}'";
    $questions = $conn->query($q_sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>

    <style>
        body { font-family: Arial; padding: 20px; }

        .box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-top: 15px;
            border-radius: 8px;
        }

        input, textarea, select {
            display: block;
            margin-bottom: 10px;
            width: 300px;
        }

        .question {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .delete-btn {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Quiz Management</h2>

<?php if ($quiz) { ?>

    <!-- <p style="color:green;">✔ Quiz already exists</p> -->

    <!-- 📖 Quiz Preview -->
    <div class="box">
        <h3><?php echo $quiz['title']; ?></h3>

        <h4>Questions:</h4>

        <?php if ($questions->num_rows > 0) { ?>

            <?php while($q = $questions->fetch_assoc()) { ?>
                <div class="question">
                    <strong><?php echo $q['question']; ?></strong><br>

                    A: <?php echo $q['option_a']; ?><br>
                    B: <?php echo $q['option_b']; ?><br>
                    C: <?php echo $q['option_c']; ?><br>
                    D: <?php echo $q['option_d']; ?><br>

                    <span style="color:green;">
                        ✔ Correct: <?php echo strtoupper($q['correct_option']); ?>
                    </span><br>

                    <!-- 🗑️ Delete -->
                    <a class="delete-btn"
                       href="../../backend/delete_question.php?id=<?php echo $q['id']; ?>"
                       onclick="return confirm('Delete this question?')">
                       Delete
                    </a>
                </div>
            <?php } ?>

        <?php } else { ?>
            <p>No questions yet.</p>
        <?php } ?>
    </div>

    <!-- ➕ Add Question -->
    <div class="box">
        <h3>Add Question</h3>

        <form action="../../backend/add_question.php" method="POST">

            <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">

            <textarea name="question" placeholder="Enter question" required></textarea>

            <input type="text" name="a" placeholder="Option A" required>
            <input type="text" name="b" placeholder="Option B" required>
            <input type="text" name="c" placeholder="Option C" required>
            <input type="text" name="d" placeholder="Option D" required>

            Correct Answer:
            <select name="correct">
                <option value="a">A</option>
                <option value="b">B</option>
                <option value="c">C</option>
                <option value="d">D</option>
            </select>

            <button type="submit">Add Question</button>
        </form>
    </div>

<?php } else { ?>

    <!-- 🆕 Create Quiz -->
    <div class="box">
        <h3>Create Quiz</h3>

        <form action="../../backend/create_quiz.php" method="POST">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            
            <input type="text" name="title" placeholder="Quiz Title" required>
            
            <button type="submit">Create Quiz</button>
        </form>
    </div>

<?php } ?>

<br>
<a href="dashboard.php">← Back to Dashboard</a>

</body>
</html>