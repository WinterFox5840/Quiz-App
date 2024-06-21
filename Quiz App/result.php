<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$score = 0;

foreach ($_POST as $question => $option_id) {
    $question_id = str_replace('question_', '', $question);
    $sql = "SELECT * FROM options WHERE id='$option_id' AND question_id='$question_id' AND is_correct=1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $score++;
    }
}

echo "Your score: $score";
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Result</title>
</head>

<body>
    <p>Your score: <?php echo $score; ?></p>
    <a href="logout.php">Logout</a>
</body>

</html>