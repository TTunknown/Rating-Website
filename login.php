<?php
session_start();

// Username & Password for reviews page
$correct_username = 'admin';
$correct_password = '1234';

// Lockout & Attempts
$lockout_time = 300; // 5 minutes (300 seconds / 60 sec = 5 min)
$max_attempts = 3;

// Lockout Check
if (isset($_SESSION['login_lockout']) && time() < $_SESSION['login_lockout']) {
    $remaining_lockout_time = $_SESSION['login_lockout'] - time();
    echo "You are locked out. Please try again after " . ceil($remaining_lockout_time / 60) . " minutes.";
    exit();
} elseif (isset($_SESSION['login_lockout']) && time() >= $_SESSION['login_lockout']) {
    // Reset if expired
    unset($_SESSION['login_attempts']);
    unset($_SESSION['login_lockout']);
}

$login_error = ''; // Error variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Initialize or increment login attempts
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    // Username & Password Check
    if ($username === $correct_username && $password === $correct_password) {
        // Successful login, reset attempts and redirect
        unset($_SESSION['login_attempts']);
        unset($_SESSION['login_lockout']);
        header('Location: adminMenu.php');
        exit();
    } else {
        // Increment login attempts
        $_SESSION['login_attempts']++;

        if ($_SESSION['login_attempts'] >= $max_attempts) {
            // User Lockout Functionality
            $_SESSION['login_lockout'] = time() + $lockout_time;
            $login_error = "You have been locked out for 5 minutes due to too many failed login attempts.";
        } else {
            $remaining_attempts = $max_attempts - $_SESSION['login_attempts'];
            $login_error = "Incorrect username or password. You have $remaining_attempts attempts remaining.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styleLogin.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($login_error): ?>
            <p><?php echo $login_error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
