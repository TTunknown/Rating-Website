<?php
// Initialize arrays 2 store counts 4 pie charts
$emoji_counts = [
    'Bad' => 0,
    'Not Good' => 0,
    'Neutral' => 0,
    'Good' => 0,
    'Great' => 0,
];
$feeling_counts = [
    'Happy' => 0,
    'Sad' => 0,
    'Angry' => 0,
    'Neutral' => 0,
    'Depressed' => 0,
];
$gender_counts = [
    'Female' => 0,
    'Male' => 0,
    'Not Telling' => 0,
];

// Reading dataStorage.txt
$reviews = [];
if (file_exists('dataStorage.txt')) {
    $file_content = file_get_contents('dataStorage.txt');
    $lines = explode("\n", trim($file_content));

    foreach ($lines as $line) {
        // Parse lines into a complete array
        list($emoji_rating, $feeling, $signature, $gender, $date_time) = explode(" | ", $line);

        // Trim spaces from parsed values
        $emoji_rating = trim(substr($emoji_rating, 13));
        $feeling = trim(substr($feeling, 9));
        $signature = trim(substr($signature, 11));
        $gender = trim(substr($gender, 8));
        $date_time = trim(substr($date_time, 11));

        // Add to reviews array
        $reviews[] = [
            'emoji_rating' => $emoji_rating,
            'feeling' => $feeling,
            'signature' => $signature,
            'gender' => $gender,
            'date_time' => $date_time
        ];

        // Increment counts for pie charts
        $emoji_counts[$emoji_rating]++;
        $feeling_counts[$feeling]++;
        $gender_counts[$gender]++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleAdmin.css">
    <title>Admin Menu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Admin Menu - Review Submissions</h2>

    <!-- Container for Pie Charts -->
    <div class="chart-container">
        <div class="chart-box">
            <canvas id="emojiChart"></canvas>
        </div>
        <div class="chart-box">
            <canvas id="feelingChart"></canvas>
        </div>
        <div class="chart-box">
            <canvas id="genderChart"></canvas>
        </div>
    </div>

    <!-- Section for the Review Cards -->
    <section>
        <h2>Submitted Reviews</h2>
        <div class="review-grid">
            <?php foreach ($reviews as $review): ?>
            <div class="review-card">
                <p><strong>Emoji Rating:</strong> <?php echo $review['emoji_rating']; ?></p>
                <p><strong>Feeling:</strong> <?php echo $review['feeling']; ?></p>
                <p><strong>Signature:</strong> <?php echo $review['signature']; ?></p>
                <p><strong>Gender:</strong> <?php echo $review['gender']; ?></p>
                <p><strong>Date/Time:</strong> <?php echo $review['date_time']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <script>
        // Pie chart for Emoji Ratings
        var ctx = document.getElementById('emojiChart').getContext('2d');
        var emojiChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Bad', 'Not Good', 'Neutral', 'Good', 'Great'],
                datasets: [{
                    label: 'Emoji Ratings',
                    data: [
                        <?php echo $emoji_counts['Bad']; ?>,
                        <?php echo $emoji_counts['Not Good']; ?>,
                        <?php echo $emoji_counts['Neutral']; ?>,
                        <?php echo $emoji_counts['Good']; ?>,
                        <?php echo $emoji_counts['Great']; ?>
                    ],
                    backgroundColor: ['#FF6347', '#FF8C00', '#FFD700', '#ADFF2F', '#32CD32'],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 18 // Increase the font size for the labels
                            }
                        }
                    }
                }
            }
        });

        // Pie chart for Feelings
        var ctx2 = document.getElementById('feelingChart').getContext('2d');
        var feelingChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Happy', 'Sad', 'Angry', 'Neutral', 'Depressed'],
                datasets: [{
                    label: 'Feelings',
                    data: [
                        <?php echo $feeling_counts['Happy']; ?>,
                        <?php echo $feeling_counts['Sad']; ?>,
                        <?php echo $feeling_counts['Angry']; ?>,
                        <?php echo $feeling_counts['Neutral']; ?>,
                        <?php echo $feeling_counts['Depressed']; ?>
                    ],
                    backgroundColor: ['#FFD700', '#1E90FF', '#FF4500', '#D3D3D3', '#A9A9A9'],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 18 // Increase the font size for the labels
                            }
                        }
                    }
                }
            }
        });

        // Pie chart for Gender
        var ctx3 = document.getElementById('genderChart').getContext('2d');
        var genderChart = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['Female', 'Male', 'Not Telling'],
                datasets: [{
                    label: 'Gender',
                    data: [
                        <?php echo $gender_counts['Female']; ?>,
                        <?php echo $gender_counts['Male']; ?>,
                        <?php echo $gender_counts['Not Telling']; ?>
                    ],
                    backgroundColor: ['#FF69B4', '#4169E1', '#A9A9A9'],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 18 // Increase the font size for the labels
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
