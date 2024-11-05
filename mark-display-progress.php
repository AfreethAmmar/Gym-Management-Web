<?php
// Include the database connection file from the parent directory
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>See Progress</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
            url(images/staffback3.jpg);
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

        .form-container {
            background-color: #81656570;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
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
        }

        .button:hover {
            background-color: #ffb9be;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #ffffff;
        }

        input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%; /* Full width */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #81656570;
            color: #fff;
        }

        table, th, td {
            border: 1px solid #fff;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #6f0f15;
        }

        .progress-result {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            color: #fff;
        }

        .goal-met {
            background-color: #28a745; /* Green for positive */
        }

        .goal-not-met {
            background-color: #dc3545; /* Red for negative */
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="mark-display-progress.php" class="button">Back to Progress Tracking</a>
        <h1>See Progress</h1>
        
        <div class="form-container">
            <form action="emily-display-progress.php" method="POST">
                <label for="client-name">Client Name:</label>
                <input type="text" id="client-name" name="client-name" required>
                
                <label for="nic">NIC:</label>
                <input type="text" id="nic" name="nic" required>
                
                <button type="submit" class="button">See Progress</button>
            </form>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $clientName = mysqli_real_escape_string($conn, $_POST['client-name']);
            $nic = mysqli_real_escape_string($conn, $_POST['nic']);

            // Fetch the goal weight from fitness_goals and current weight from client_progress
            $goalQuery = "SELECT goal_weight FROM mark_fitness_goals WHERE client_name = '$clientName' AND nic = '$nic'";
            $progressQuery = "SELECT weight FROM mark_client_progress WHERE client_name = '$clientName' AND nic = '$nic' ORDER BY month DESC LIMIT 1";

            $goalResult = mysqli_query($conn, $goalQuery);
            $progressResult = mysqli_query($conn, $progressQuery);

            if (mysqli_num_rows($goalResult) > 0 && mysqli_num_rows($progressResult) > 0) {
                $goalRow = mysqli_fetch_assoc($goalResult);
                $progressRow = mysqli_fetch_assoc($progressResult);

                $goalWeight = $goalRow['goal_weight'];
                $currentWeight = $progressRow['weight'];
                $weightDifference = $currentWeight - $goalWeight;

                echo "<table>
                        <tr>
                            <th>Client Name</th>
                            <th>NIC</th>
                            <th>Goal Weight (kg)</th>
                            <th>Current Weight (kg)</th>
                            <th>Difference (kg)</th>
                        </tr>
                        <tr>
                            <td>$clientName</td>
                            <td>$nic</td>
                            <td>$goalWeight</td>
                            <td>$currentWeight</td>
                            <td>" . abs($weightDifference) . "</td>
                        </tr>
                      </table>";

                // Display the result based on the goal met or not
                if ($weightDifference <= 0) {
                    echo "<div class='progress-result goal-met'>Congratulations! The client has met or exceeded their goal!</div>";
                } else {
                    echo "<div class='progress-result goal-not-met'>The client is still $weightDifference kg away from their goal.</div>";
                }
            } else {
                echo "<div class='progress-result goal-not-met'>No data found for the specified client.</div>";
            }

            // Close the connection
            mysqli_close($conn);
        }
        ?>
    </div>
</body>
</html>
