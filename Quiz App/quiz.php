<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch questions and options
$sql = "SELECT q.id AS question_id, q.question, o.id AS option_id, o.option_text
        FROM questions q
        JOIN options o ON q.id = o.question_id";
$result = $conn->query($sql);

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[$row['question_id']]['question'] = $row['question'];
    $questions[$row['question_id']]['options'][] = [
        'option_id' => $row['option_id'],
        'option_text' => $row['option_text']
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quiz</title>
</head>

<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <a href="add_question.php">Add New Question</a>
    <a href="remove_question.php">Remove Question</a>
    <form method="post" action="result.php">
        <?php foreach ($questions as $question_id => $question) : ?>
            <p><?php echo $question['question']; ?></p>
            <?php foreach ($question['options'] as $option) : ?>
                <input type="radio" name="question_<?php echo $question_id; ?>" value="<?php echo $option['option_id']; ?>" required>
                <?php echo $option['option_text']; ?><br>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <input type="submit" value="Submit Quiz">
    </form>
</body>

</html>