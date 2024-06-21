<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET['question_id'])) {
    $question_id = isset($_POST['question_id']) ? $_POST['question_id'] : $_GET['question_id'];

    // Delete options first due to foreign key constraint
    $sql = "DELETE FROM options WHERE question_id='$question_id'";
    if ($conn->query($sql) === TRUE) {
        // Delete the question
        $sql = "DELETE FROM questions WHERE id='$question_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Question removed successfully!";
        } else {
            echo "Error removing question: " . $conn->error;
        }
    } else {
        echo "Error removing options: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Remove Question</title>
</head>
<body>
    <h1>Remove a Question</h1>
    <form method="post" action="remove_question.php">
        Question ID: <input type="text" name="question_id" required><br>
        <input type="submit" value="Remove Question">
    </form>
    <a href="quiz.php">Back to Quiz</a>
</body>
</html>
