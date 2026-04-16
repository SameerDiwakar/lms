<?php
include 'db.php';

$quiz_id = $_POST['quiz_id'];

$sql = "INSERT INTO questions 
(quiz_id, question, option_a, option_b, option_c, option_d, correct_option)
VALUES (
'$quiz_id',
'{$_POST['question']}',
'{$_POST['a']}',
'{$_POST['b']}',
'{$_POST['c']}',
'{$_POST['d']}',
'{$_POST['correct']}'
)";

$conn->query($sql);

echo "Question added!";
?>