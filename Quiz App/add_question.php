<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $options = $_POST['options'];
    $correct_option = $_POST['correct_option'];

    // Insert question
    $sql = "INSERT INTO questions (question) VALUES ('$question')";
    if ($conn->query($sql) === TRUE) {
        $question_id = $conn->insert_id;

        // Insert options
        foreach ($options as $key => $option) {
            $is_correct = ($key == $correct_option) ? 1 : 0;
            $sql = "INSERT INTO options (question_id, option_text, is_correct) VALUES ('$question_id', '$option', '$is_correct')";
            $conn->query($sql);
        }
        echo "Question added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Question</title>
</head>

<body>
    <h1>Add a New Question</h1>
    <form method="post" action="add_question.php">
        Question: <input type="text" name="question" required><br>
        Option 1: <input type="text" name="options[]" required><br>
        Option 2: <input type="text" name="options[]" required><br>
        Option 3: <input type="text" name="options[]" required><br>
        Option 4: <input type="text" name="options[]" required><br>
        Correct Option:
        <select name="correct_option">
            <option value="0">Option 1</option>
            <option value="1">Option 2</option>
            <option value="2">Option 3</option>
            <option value="3">Option 4</option>
        </select><br>
        <input type="submit" value="Add Question">
    </form>
    <a href="quiz.php">Back to Quiz</a>
</body>

</html>