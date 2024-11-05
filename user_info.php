<?php
// process_payment.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form values
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $paymentMethod = htmlspecialchars($_POST['paymentMethod']);
    $selectedPlan = htmlspecialchars($_POST['selectedPlan']);
    $selectedPrice = htmlspecialchars($_POST['selectedPrice']);

    // Database connection details
    $host = 'localhost'; // your DB host
    $db = 'gymtrack'; // your database name
    $user = 'root'; // your MySQL username
    $pass = ''; // your MySQL password
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        // Create a database connection using PDO
        $conn = new PDO($dsn, $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert query to store the form data into the plan_price table
        $sql = "INSERT INTO plan_price (name, email, phone, payment_method, plan_name, plan_price) 
                VALUES (:name, :email, :phone, :paymentMethod, :planName, :planPrice)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':paymentMethod', $paymentMethod);
        $stmt->bindParam(':planName', $selectedPlan);
        $stmt->bindParam(':planPrice', $selectedPrice);

        // Execute the query
        $stmt->execute();

        // Redirect the user to a success or confirmation page
        header("Location: user_info.php");
        exit();
    } catch (PDOException $e) {
        // Handle any database connection errors
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <style>
        /* Reset some default browser styles */
        body, h1, p {
            margin: 0;
            padding: 0;
        }

        /* Body styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        h1 {
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }

        form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #34495e;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #fafafa;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #3498db;
        }

        button {
            padding: 14px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        p {
            margin-bottom: 20px;
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Enter Your Information</h1>

    <?php
    // Get the selected plan and price from the URL query parameters
    $selectedPlan = htmlspecialchars($_GET['selectedPlan'] ?? 'Not selected');
    $selectedPrice = htmlspecialchars($_GET['selectedPrice'] ?? 'Not specified');
    ?>

    <p>Selected Plan: <?php echo $selectedPlan; ?></p>
    <p>Price: <?php echo $selectedPrice; ?>/-</p>

    <form action="user_info.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="paymentMethod">Payment Method:</label>
        <select id="paymentMethod" name="paymentMethod" required>
            <option value="Credit Card">Card Payment</option>
            <option value="PayPal">Cash Payment</option>
        </select>

        <input type="hidden" id="selectedPlan" name="selectedPlan" value="<?php echo $selectedPlan; ?>">
        <input type="hidden" id="selectedPrice" name="selectedPrice" value="<?php echo $selectedPrice; ?>">

        <button type="submit">Proceed to Payment</button>
        <button id="backButton">Back</button>

    </form>
    <script>
    document.querySelector("#backButton").addEventListener("click", function(event) {
        // Prevent the form from being submitted
        event.preventDefault();
        if (confirm("Are you sure you want to go back?")) {
            // Redirect to the back page if the user confirms
            window.location.href = "index.php.#price";
        }
    });
</script>
<script>
    // JavaScript to alert on form submission
    document.querySelector("form").addEventListener("submit", function(event) {
        alert("Form has been submitted successfully!");
    });
</script>

</body>
</html>
