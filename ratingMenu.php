<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data
    $emoji_rating = $_POST['emoji_rating'];
    $feeling = $_POST['feeling'];
    $signature = $_POST['signature'];
    $gender = $_POST['gender'];
    $date_time = date('Y-m-d H:i:s'); // Current date and time

    // Signature Check
    $file_content = file_get_contents('dataStorage.txt');
    if (strpos($file_content, $signature) !== false) {
        echo "This signature already exists. Please choose a unique signature.";
    } else {
        // Review String
        $review = "Emoji Rating: $emoji_rating | Feeling: $feeling | Signature: $signature | Gender: $gender | Date/Time: $date_time\n";

        // Reviews Written
        file_put_contents('dataStorage.txt', $review, FILE_APPEND);

        // Confirmation
        echo "Your review has been submitted successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Menu</title>
    <link rel="stylesheet" href="styleRating.css">
</head>
<body>
    <div class="container">
        <h2>Submit Your Review</h2>
        <form action="ratingMenu.php" method="POST">
            <!-- Rating -->
            <label for="emoji_rating">Rate Us:</label>
            <div>
                <input type="radio" id="bad" name="emoji_rating" value="Bad" required>
                <label for="bad"><img src="bad_emoji.png" alt="Bad" width="50" height="50"></label>

                <input type="radio" id="not_good" name="emoji_rating" value="Not Good">
                <label for="not_good"><img src="not_good_emoji.png" alt="Not Good" width="50" height="50"></label>

                <input type="radio" id="neutral" name="emoji_rating" value="Neutral">
                <label for="neutral"><img src="neutral_emoji.png" alt="Neutral" width="50" height="50"></label>

                <input type="radio" id="good" name="emoji_rating" value="Good">
                <label for="good"><img src="good_emoji.png" alt="Good" width="50" height="50"></label>

                <input type="radio" id="great" name="emoji_rating" value="Great">
                <label for="great"><img src="great_emoji.png" alt="Great" width="50" height="50"></label>
            </div>

            <!-- Feeling -->
            <label for="feeling">How do you feel currently?</label>
            <select id="feeling" name="feeling" required>
                <option value="Happy">Happy</option>
                <option value="Sad">Sad</option>
                <option value="Angry">Angry</option>
                <option value="Neutral">Neutral</option>
                <option value="Depressed">Depressed</option>
            </select>

            <!-- Signature -->
            <label for="signature">Your Signature:</label>
            <input type="text" id="signature" name="signature" required>

            <!-- Gender -->
            <label for="gender">Gender:</label>
            <div>
                <input type="radio" id="female" name="gender" value="Female" required>
                <label for="female">Female</label>

                <input type="radio" id="male" name="gender" value="Male">
                <label for="male">Male</label>

                <input type="radio" id="not_telling" name="gender" value="Not Telling">
                <label for="not_telling">Not Telling</label>
            </div>

            <input type="submit" value="Submit">
        </form>

        <form action="login.php" method="GET" style="margin-top: 20px;">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
