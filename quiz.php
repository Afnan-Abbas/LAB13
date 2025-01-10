<?php
session_start();
include('includes/dbconnect.php');

// Fetch total questions
$query = "SELECT COUNT(*) AS total FROM questions";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_questions = $row['total'];

if (!isset($_SESSION['current_question'])) {
    $_SESSION['current_question'] = 1;
    $_SESSION['answers'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question_id = $_POST['question_id'];
    $user_answer = $_POST['answer'] ?? '';
    $_SESSION['answers'][$question_id] = $user_answer;
    $_SESSION['current_question']++;
}

if ($_SESSION['current_question'] > $total_questions) {
    header('Location: result.php');
    exit;
}

$current_question = $_SESSION['current_question'];
$query = "SELECT * FROM questions WHERE id = $current_question";
$result = mysqli_query($conn, $query);
$question = mysqli_fetch_assoc($result);
?>
<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="assets/css/style.css">
<main class="quiz-container">
    <h1>Question <?php echo $current_question; ?> of <?php echo $total_questions; ?></h1>
    <form method="POST" action="quiz.php" class="quiz-form">
        <p class="quiz-question"><?php echo $question['question']; ?></p>
        <input type="hidden" name="question_id" value="<?php echo $question['id']; ?>">
        <div class="quiz-options">
            <label>
                <input type="radio" name="answer" value="a" required>
                <span><?php echo $question['option_a']; ?></span>
            </label><br>
            <label>
                <input type="radio" name="answer" value="b" required>
                <span><?php echo $question['option_b']; ?></span>
            </label><br>
            <label>
                <input type="radio" name="answer" value="c" required>
                <span><?php echo $question['option_c']; ?></span>
            </label><br>
            <label>
                <input type="radio" name="answer" value="d" required>
                <span><?php echo $question['option_d']; ?></span>
            </label>
        </div>
        <button type="submit" class="next-btn">Next</button>
    </form>
</main>
<?php include('includes/footer.php'); ?>
