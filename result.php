<?php
session_start();
include('includes/dbconnect.php');

// Fetch total questions and calculate score
$query = "SELECT * FROM questions";
$result = mysqli_query($conn, $query);

$score = 0;
$total_questions = mysqli_num_rows($result);

foreach ($result as $row) {
    $question_id = $row['id'];
    $correct = $row['correct'];
    $user_answer = $_SESSION['answers'][$question_id] ?? '';
    if ($user_answer == $correct) $score++;
}

session_destroy();
?>
<?php include('includes/header.php'); ?>
<link rel="stylesheet" href="assets/css/style.css">
<main class="quiz-container">
    <h1>Your Quiz Results</h1>
    <div class="progress-container">
        <div class="circle-progress">
            <div class="circle-inner">
                <span id="progress-percentage"><?php echo round(($score / $total_questions) * 100); ?>%</span>
            </div>
        </div>
    </div>
    <p class="score-msg">You scored <strong><?php echo $score; ?></strong> out of <strong><?php echo $total_questions; ?></strong>.</p>
    <div class="try-again-container">
        <a href="quiz.php" class="try-again-btn">Try Again</a>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Smooth Circular Progress Bar Animation
        const scorePercentage = <?php echo round(($score / $total_questions) * 100); ?>;
        const circleProgress = document.querySelector(".circle-progress");
        circleProgress.style.setProperty("--progress-value", scorePercentage);

        // Button Animation
        const tryAgainButton = document.querySelector(".try-again-btn");
        tryAgainButton.addEventListener("mouseenter", () => {
            tryAgainButton.style.transform = "scale(1.05)";
        });
        tryAgainButton.addEventListener("mouseleave", () => {
            tryAgainButton.style.transform = "scale(1)";
        });
    });
</script>
<?php include('includes/footer.php'); ?>
