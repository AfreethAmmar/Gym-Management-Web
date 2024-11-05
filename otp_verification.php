<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .otp-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h2>Enter OTP</h2>
        <form action="validate_otp.php" method="POST">
            <input type="text" name="otp" placeholder="Enter the OTP" required>
            <input type="submit" value="Verify OTP">
        </form>
    </div>
</body>
</html>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enteredOtp = $_POST['otp'];
    $storedOtp = $_SESSION['otp'];

    if ($enteredOtp == $storedOtp) {
        echo "OTP verified successfully!";
        // Redirect or continue with further actions (e.g., registration or login)
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
