<?php
// login.php

session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        $message = "Username and password are required.";
    } else {
        // Connect to SQLite database
        $connection = new SQLite3('list.db');

        // Check if user exists in the db
        $stmt = $connection->prepare("SELECT * FROM user WHERE username = ?");
        $result = $stmt->bindValue(1, $username);
        $result = $stmt->execute();

        if ($row = $result->fetchArray()) {
            // Verify password
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: index.php");
                exit;
            } else {
                $message = "Invalid username or password.";
            }
        } else {
            $message = "User not found.";
        }

        $connection->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; background-color: #f4f4f4; }
        .login-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 400px; margin:auto; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007cba; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-size: 16px; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>
    
    <?php if ($message): ?>
        <p class="error"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>

    <!-- Optional: Add register link -->
    <?php // <p><a href="register.php">Don't have an account? Register here.</a></p> ?>
</div>

</body>
</html>
