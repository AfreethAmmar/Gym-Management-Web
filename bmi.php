<?php
include 'connection.php';

// Start the session to store temporary data
session_start();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which form was submitted
    if (isset($_POST['calculate_bmi'])) {
        // Retrieve and sanitize form data
        $_SESSION['age'] = intval($_POST['age']);
        $_SESSION['gender'] = $_POST['gender'];
        $_SESSION['height'] = floatval($_POST['height']);
        $_SESSION['weight'] = floatval($_POST['weight']);
        $bmi = ($_SESSION['weight'] / (($_SESSION['height'] / 100) ** 2));
        $_SESSION['bmi'] = round($bmi, 2);

        // Determine recommendations based on BMI
        if ($bmi < 18.5) {
            $_SESSION['recommendation'] = "Strength Training";
        } elseif ($bmi < 24.9) {
            $_SESSION['recommendation'] = "Group Fitness";
        } elseif ($bmi < 29.9) {
            $_SESSION['recommendation'] = "Weight Loss";
        } else {
            $_SESSION['recommendation'] = "Weight Loss";
        }

        // Redirect to the same page to display the BMI and open the recommendations modal
        header("Location: bmi.php");
        exit();
    } elseif (isset($_POST['submit_details'])) {
        // Retrieve user details and recommendations
        $age = $_SESSION['age'];
        $gender = $_SESSION['gender'];
        $height = $_SESSION['height'];
        $weight = $_SESSION['weight'];
        $bmi = $_SESSION['bmi'];
        $recommendation = $_SESSION['recommendation'];

        $name = $conn->real_escape_string($_POST['name']);
        $address = $conn->real_escape_string($_POST['address']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $sessionDate = $conn->real_escape_string($_POST['sessionDate']);

        // Determine the table to insert into based on the recommendation
        if ($recommendation === "Strength Training") {
            $sql = "INSERT INTO bmi_strength_training (age, gender, height, weight, bmi, name, address, phone, session_date) 
                    VALUES ('$age', '$gender', '$height', '$weight', '$bmi', '$name', '$address', '$phone', '$sessionDate')";
        } elseif ($recommendation === "Group Fitness") {
            $sql = "INSERT INTO bmi_group_fitness (age, gender, height, weight, bmi, name, address, phone, session_date) 
                    VALUES ('$age', '$gender', '$height', '$weight', '$bmi', '$name', '$address', '$phone', '$sessionDate')";
        } else { // Weight Loss
            $sql = "INSERT INTO bmi_weight_loss (age, gender, height, weight, bmi, name, address, phone, session_date) 
                    VALUES ('$age', '$gender', '$height', '$weight', '$bmi', '$name', '$address', '$phone', '$sessionDate')";
        }

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('BMI record saved successfully!');</script>";
        } else {
            echo "Error: " . $conn->error;
        }

        // Clear session data
        session_unset();
        session_destroy();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Calculator</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e2f;
            color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3 {
            text-align: center;
            color: #fff;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #29293d;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #3c3c57;
            color: #fff;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #5865f2;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #4754c2;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* BMI Result */
        #result {
            margin-top: 20px;
            padding: 20px;
            background-color: #2f2f44;
            border-radius: 5px;
            text-align: center;
        }

        #bmiValue, #bmiStatus {
            font-size: 18px;
            margin-top: 10px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #29293d;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            text-align: center;
            color: #fff;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #fff;
            cursor: pointer;
        }

        #modalTitle, #modalBmiValue, #selectedRecommendations {
            margin-bottom: 20px;
        }

        /* Modal Buttons */
        button[type="button"] {
            background-color: #4caf50;
        }

        button[type="button"]:hover {
            background-color: #45a049;
        }

        button[type="submit"] {
            background-color: #008cba;
        }

        button[type="submit"]:hover {
            background-color: #007bb5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>BMI Calculator</h1>
        <form id="bmiForm" action="bmi.php" method="POST">
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="2" max="120" required value="<?php echo isset($_SESSION['age']) ? $_SESSION['age'] : ''; ?>">
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <input type="radio" id="male" name="gender" value="Male" required <?php if(isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male') echo 'checked'; ?>> Male
                <input type="radio" id="female" name="gender" value="Female" required <?php if(isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female') echo 'checked'; ?>> Female
            </div>

            <div class="form-group">
                <label for="height">Height (cm):</label>
                <input type="number" id="height" name="height" required value="<?php echo isset($_SESSION['height']) ? $_SESSION['height'] : ''; ?>">
            </div>

            <div class="form-group">
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" required value="<?php echo isset($_SESSION['weight']) ? $_SESSION['weight'] : ''; ?>">
            </div>

            <button type="submit" name="calculate_bmi">Calculate BMI</button>
            <button type="button"><a href="index.php.#class" style="color: white; text-decoration: none;">Back</a></button>
        </form>

        <div id="result">
            <h2>Result</h2>
            <p id="bmiValue">
                <?php
                if (isset($_SESSION['bmi'])) {
                    echo "Your BMI is: " . $_SESSION['bmi'];
                }
                ?>
            </p>
            <p id="bmiStatus">
                <?php
                if (isset($_SESSION['bmi'])) {
                    if ($_SESSION['bmi'] < 18.5) {
                        echo "Status: Underweight";
                    } elseif ($_SESSION['bmi'] < 24.9) {
                        echo "Status: Normal weight";
                    } elseif ($_SESSION['bmi'] < 29.9) {
                        echo "Status: Overweight";
                    } else {
                        echo "Status: Obesity";
                    }
                }
                ?>
            </p>
        </div>
    </div>

    <?php if (isset($_SESSION['bmi'])): ?>
<div class="modal" id="recommendationModal" style="display: flex;">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('recommendationModal').style.display='none'">&times;</span>
        <h3 id="modalTitle">Recommendations for You</h3>
        <p id="modalBmiValue">Your BMI is: <?php echo $_SESSION['bmi']; ?></p>
        <p id="selectedRecommendations">Based on your BMI, we recommend: <?php echo $_SESSION['recommendation']; ?></p>
        <form action="bmi.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required placeholder="Enter your name" value="<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>">

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required placeholder="Enter your address" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : ''; ?>">

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required placeholder="Enter your phone number" value="<?php echo isset($_SESSION['phone']) ? $_SESSION['phone'] : ''; ?>">

            <label for="sessionDate">Select Session Date:</label>
            <input type="datetime-local" id="sessionDate" name="sessionDate" required>

            <button type="submit" name="submit_details">Save Record</button>
        </form>
    </div>
</div>
<?php endif; ?>


    <script>
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('recommendationModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    </script>
</body>
</html>
