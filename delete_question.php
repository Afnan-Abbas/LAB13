<?php
session_start();
require_once '../Includes/dbconnect.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit();
}

// Check if the question ID is provided
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the question ID

    // Delete the question
    $delete_query = "DELETE FROM questions WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Reorder the table after deletion
        $reorder_query = "
            SET @new_id = 0;
            UPDATE questions SET id = (@new_id := @new_id + 1);
            ALTER TABLE questions AUTO_INCREMENT = 1;
        ";

        // Execute the reordering query
        if ($conn->multi_query($reorder_query)) {
            // Success message after deletion and reordering
            $_SESSION['success_message'] = "Question deleted and table reordered successfully.";
        } else {
            $_SESSION['error_message'] = "Failed to reorder the table.";
        }
    } else {
        $_SESSION['error_message'] = "Failed to delete the question.";
    }

    $stmt->close();
    header("Location: manage.php"); // Redirect to manage questions page
    exit();
} else {
    $_SESSION['error_message'] = "Invalid question ID.";
    header("Location: manage.php");
    exit();
}
