<?php
session_start();
require_once '../Includes/dbconnect.php';

$error = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the admin user from the database
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        // Verify the password (in future use password_hash)
        if ($password === $admin['password']) {
            // Login successful
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin'] = $admin['username'];
            header("Location: manage.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Invalid username.";
    }
}
?>

<?php include('../Includes/header-admin.php'); ?>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/script.js"></script>
<main class="hero-section">
    <div class="login-container">
        <div class="content">
            <h1>Admin Login</h1>
            <p>Securely access the admin dashboard to manage the platform.</p>
            <form action="admin.php" method="post" class="admin-login-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit" class="login-btn">Login</button>

            </form>
            <?php if ($error): ?>
                <p class="error" style="color: red; margin-top: 20px;"><?= $error ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>
<?php include('../Includes/footer.php'); ?>
