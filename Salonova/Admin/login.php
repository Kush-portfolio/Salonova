<?php
session_start();
include 'db.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['seller'])) {
    header("Location: dashboard.php");
    exit();
}

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic validation
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $login_error = "Username and Password are required.";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $query = "SELECT * FROM sellers WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_regenerate_id(true);
            $_SESSION['seller'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $login_error = "Invalid credentials.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - Salonova</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .login-container { max-width: 400px; margin: 80px auto; padding: 30px; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        label { display: block; margin: 15px 0 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; }
        button { margin-top: 20px; width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Seller Login</h2>
        <?php if ($login_error): ?>
            <div class="error"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>
        <form action="" method="POST" autocomplete="off">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required autofocus />

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required />

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
