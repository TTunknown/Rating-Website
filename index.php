<?php
// Set the initial CD time
$seconds_remaining = isset($_GET['time']) ? (int)$_GET['time'] : 10;

// Check for zero point on CD
if ($seconds_remaining <= 0) {
    // Redirect to rating menu
    header('Location: ratingMenu.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styleIndex.css">
    <script>
        // PHP to JS
        var countdownTime = <?php echo $seconds_remaining; ?>;

        // Func for CD
        function updateCountdown() {
            if (countdownTime > 1) {
                countdownTime--;
                document.getElementById('countdown').innerText = countdownTime;
            } else {
                // Redirect @ 0
                window.location.href = 'ratingMenu.php';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('countdown').innerText = countdownTime;
            // 1 sec delay (1000ms)
            setInterval(updateCountdown, 1000);
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="welcome-text">Welcome</div>
        <div class="redirect-text">
            Redirecting to Main Rating Page in: <span id="countdown"><?php echo $seconds_remaining; ?></span> seconds.
        </div>
    </div>
</body>
</html>
