<?php
// Include the database connection file from the parent directory
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracking</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url( images/staffback3.jpg   );
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #ffb9be;
            padding-bottom: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #6f0f15;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
            text-align: center;
            margin: 0 10px; /* Added margin for spacing */
        }

        .button:hover {
            background-color: #ffb9be;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="emilyStaffDashbord.php" class="button">Back to Dashboard</a>
        <h1>Progress Tracking</h1>
        <div style="text-align: center;">
            <a href="emily-set-goal.php" class="button">Set Goal</a>
            <a href="emily-update-progress.php" class="button">Track Progress</a>
            <a href="emily-display-progress.php" class="button">See Progress</a>
        </div>
    </div>
</body>
</html>
