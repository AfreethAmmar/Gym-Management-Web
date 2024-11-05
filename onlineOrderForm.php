<?php include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form Popup</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .order-button {
            display: block;
            margin: 30px auto;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .order-button:hover {
            background-color: #218838;
        }
        .order-button a{
            text-decoration: none;
            color: white;
        }
        /* Popup Styles */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 500px;
            position: relative;
        }

        .popup-content h2 {
            margin-top: 0;
            font-size: 1.5rem;
            color: #333;
        }

        .popup-content input,
        .popup-content select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .popup-content label {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #333;
        }

        .popup-content button {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .popup-content button:hover {
            background-color: #0056b3;
        }

        .popup-content .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            color: #aaa;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <button class="order-button">Place Order</button>
    <button class="order-button"><a href="index.php">Back</a></button>

    <div id="orderPopup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Order Form</h2>

            <form id="orderForm">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="street">Street Address:</label>
                <input type="text" id="street" name="street" required>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>

                <label for="state">State:</label>
                <input type="text" id="state" name="state" required>

                <label for="zipcode">Zip Code:</label>
                <input type="text" id="zipcode" name="zipcode" required>

                <label for="country">Country:</label>
                <input type="text" id="country" name="country" required>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="size">Size:</label>
                <select id="size" name="size" required>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>

                <label for="payment">Payment Method:</label>
                <select id="payment" name="payment" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>

                <button type="submit">Submit Order</button>
            </form>
        </div>
    </div>

    <script>
        // Open Popup
        document.querySelector('.order-button').addEventListener('click', function () {
            document.getElementById('orderPopup').style.display = 'flex';
        });

        // Close Popup
        document.querySelector('.close').addEventListener('click', function () {
            document.getElementById('orderPopup').style.display = 'none';
        });

        // Close Popup when clicking outside the content
        window.addEventListener('click', function (e) {
            if (e.target === document.getElementById('orderPopup')) {
                document.getElementById('orderPopup').style.display = 'none';
            }
        });

        // Handle Form Submission
        document.getElementById('orderForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Here you can add AJAX or other logic to process the form data
            alert("Order submitted successfully!");

            // Close the popup after submission
            document.getElementById('orderPopup').style.display = 'none';
        });
    </script>

</body>
</html>
