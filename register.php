<?php
// register.php
    ini_set('session.gc_maxlifetime', '0');
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $connection = new SQLite3('list.db');
    $stmt = $connection->prepare("INSERT INTO user (username, password) VALUES (?, ?)");
    $stmt->bindValue(1, $username);
    $stmt->bindValue(2, $password);
    if ($stmt->execute()) {
        echo "<p>Registration successful! <a href='login.php'>Login now.</a></p>";
    } else {
        echo "Error registering.";
    }
    $connection->close();
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit">Register</button>
</form>
