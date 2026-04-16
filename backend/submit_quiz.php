<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$quiz_id = $_POST['quiz_id'];

$sql = "SELECT * FROM questions WHERE quiz_id='$quiz_id'";
$result = $conn->query($sql);

$score = 0;

while($q = $result->fetch_assoc()) {
    $qid = $q['id'];
    $correct = $q['correct_option'];

    if (isset($_POST["q$qid"]) && $_POST["q$qid"] == $correct) {
        $score++;
    }
}

$conn->query("INSERT INTO results (user_id, quiz_id, score)
              VALUES ('$user_id', '$quiz_id', '$score')");

echo "Your score: $score";
?>