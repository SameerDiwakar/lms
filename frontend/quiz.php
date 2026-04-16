<?php
session_start();
include '../backend/db.php';

$quiz_id = $_GET['id'];

$sql = "SELECT * FROM questions WHERE quiz_id='$quiz_id'";
$result = $conn->query($sql);
?>

<h2>Quiz</h2>

<form action="../backend/submit_quiz.php" method="POST">

<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

<?php
$i = 1;
while($row = $result->fetch_assoc()) {
?>

<p><?php echo $i++ . ". " . $row['question']; ?></p>

<input type="radio" name="q<?php echo $row['id']; ?>" value="a"> <?php echo $row['option_a']; ?><br>
<input type="radio" name="q<?php echo $row['id']; ?>" value="b"> <?php echo $row['option_b']; ?><br>
<input type="radio" name="q<?php echo $row['id']; ?>" value="c"> <?php echo $row['option_c']; ?><br>
<input type="radio" name="q<?php echo $row['id']; ?>" value="d"> <?php echo $row['option_d']; ?><br><br>

<?php } ?>

<button type="submit">Submit Quiz</button>

</form>