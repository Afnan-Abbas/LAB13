<?php
session_start();
require_once '../Includes/dbconnect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit();
}

$message = "";

// Fetch the question to edit
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $question_id = $_GET['id'];

    $query = "SELECT * FROM questions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $question = $result->fetch_assoc();
    } else {
        die("Question not found.");
    }
} else {
    die("Invalid request.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $question_text = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct = $_POST['correct'];

    // Validate inputs
    if (!empty($question_text) && !empty($option_a) && !empty($option_b) && !empty($option_c) && !empty($option_d) && !empty($correct)) {
        $update_query = "UPDATE questions SET question = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssssssi", $question_text, $option_a, $option_b, $option_c, $option_d, $correct, $question_id);

        if ($stmt->execute()) {
            $message = "Question updated successfully!";
        } else {
            $message = "Error updating question: " . $conn->error;
        }
    } else {
        $message = "All fields are required.";
    }
}

?>

<?php include('../Includes/header-manage.php'); ?>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>

<main class="admin-popup-section">
    <div class="admin-popup-container">
        <div class="admin-popup-content">
            <h1 class="admin-popup-title">Edit Question</h1>
            <?php if (!empty($message)): ?>
                <p class="admin-popup-message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form method="POST" action="" class="admin-popup-form">
                <div class="admin-popup-group">
                    <label for="question">Question:</label>
                    <textarea id="question" name="question" rows="3" required><?= htmlspecialchars($question['question']) ?></textarea>
                </div>

                <div class="admin-popup-group">
                    <label for="option_a">Option A:</label>
                    <input type="text" id="option_a" name="option_a" value="<?= htmlspecialchars($question['option_a']) ?>" required>
                </div>

                <div class="admin-popup-group">
                    <label for="option_b">Option B:</label>
                    <input type="text" id="option_b" name="option_b" value="<?= htmlspecialchars($question['option_b']) ?>" required>
                </div>

                <div class="admin-popup-group">
                    <label for="option_c">Option C:</label>
                    <input type="text" id="option_c" name="option_c" value="<?= htmlspecialchars($question['option_c']) ?>" required>
                </div>

                <div class="admin-popup-group">
                    <label for="option_d">Option D:</label>
                    <input type="text" id="option_d" name="option_d" value="<?= htmlspecialchars($question['option_d']) ?>" required>
                </div>

                <div class="admin-popup-group">
                    <label for="correct">Correct Answer:</label>
                    <select id="correct" name="correct" required>
                        <option value="a" <?= $question['correct'] === 'a' ? 'selected' : '' ?>>A</option>
                        <option value="b" <?= $question['correct'] === 'b' ? 'selected' : '' ?>>B</option>
                        <option value="c" <?= $question['correct'] === 'c' ? 'selected' : '' ?>>C</option>
                        <option value="d" <?= $question['correct'] === 'd' ? 'selected' : '' ?>>D</option>
                    </select>
                </div>

                <button type="submit" class="admin-popup-submit-btn">Update Question</button>
            </form>
            <a href="manage.php" class="admin-popup-back-link">Back to Manage Questions</a>
        </div>
    </div>
</main>

<?php include('../Includes/footer.php'); ?>
