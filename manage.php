<?php
session_start();
require_once '../Includes/dbconnect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit();
}

// Fetch all questions from the database
$query = "SELECT * FROM questions";
$result = mysqli_query($conn, $query);

// Check for success or error messages in the session
$success_message = $_SESSION['success_message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';

// Clear the messages from the session
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>

<?php include('../Includes/header-manage.php'); ?>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>

<main class="manage-section">
    <div class="manage-container">
        <div class="content">
            <h1 class="title">Manage Questions</h1>
            <p class="subtitle">View, edit, delete, or add new questions to your quiz.</p>

            <!-- Success and Error Messages -->
            <?php if (!empty($success_message)) : ?>
                <p class="message success" id="message"><?= $success_message ?></p>
            <?php endif; ?>

            <?php if (!empty($error_message)) : ?>
                <p class="message error" id="message"><?= $error_message ?></p>
            <?php endif; ?>

            <!-- Questions Table -->
            <div class="table-container">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Option A</th>
                            <th>Option B</th>
                            <th>Option C</th>
                            <th>Option D</th>
                            <th>Correct Answer</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['question'] ?></td>
                                    <td><?= $row['option_a'] ?></td>
                                    <td><?= $row['option_b'] ?></td>
                                    <td><?= $row['option_c'] ?></td>
                                    <td><?= $row['option_d'] ?></td>
                                    <td><?= $row['correct'] ?></td>
                                    <td class="action-links">
                                        <a href="edit_question.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                                        <a href="delete_question.php?id=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8">No questions found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="action-container">
                <a href="add_question.php" class="add-btn">Add New Question</a>
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<?php include('../Includes/footer.php'); ?>
