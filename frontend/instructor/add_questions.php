<?php
$quiz_id = $_GET['quiz_id'];
?>

<h2>Add Question</h2>

<form action="../../backend/add_question.php" method="POST">
    <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

    <input type="text" name="question" placeholder="Question"><br><br>

    <input type="text" name="a" placeholder="Option A"><br>
    <input type="text" name="b" placeholder="Option B"><br>
    <input type="text" name="c" placeholder="Option C"><br>
    <input type="text" name="d" placeholder="Option D"><br><br>

    Correct:
    <select name="correct">
        <option value="a">A</option>
        <option value="b">B</option>
        <option value="c">C</option>
        <option value="d">D</option>
    </select><br><br>

    <button type="submit">Add Question</button>
</form>