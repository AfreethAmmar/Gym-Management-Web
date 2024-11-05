<?php

   include 'connection.php'

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout Form</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
      }

      .container {
        width: 80%;
        margin: 50px auto;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
      }

      .row {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
      }

      .column {
        width: 48%;
      }

      .form-group {
        margin-bottom: 15px;
      }

      label {
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
        color: #333;
      }

      input[type="text"],
      input[type="email"],
      input[type="number"],
      select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
      }

      .cards {
        margin-bottom: 10px;
      }

      .cards img {
        width: 50px;
        margin-right: 10px;
      }

      .proceed-btn {
        display: block;
        width: 100%;
        padding: 15px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        margin-top: 20px;
      }

      .proceed-btn:hover {
        background-color: #218838;
      }

      @media (max-width: 768px) {
        .column {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2>Checkout Form</h2>
      <div class="row">
        <!-- Billing Address -->
        <div class="column">
          <h3>Billing Address</h3>
          <div class="form-group">
            <label for="full-name">Full Name:</label>
            <input type="text" id="full-name" name="full-name" required />
          </div>

          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required />
          </div>

          <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required />
          </div>

          <div class="form-group">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required />
          </div>

          <div class="form-group">
            <label for="state">State:</label>
            <input type="text" id="state" name="state" required />
          </div>

          <div class="form-group">
            <label for="zip">Zip Code:</label>
            <input type="text" id="zip" name="zip" required />
          </div>
        </div>

        <!-- Payment Section -->
        <div class="column">
          <h3>Payment</h3>
          <div class="form-group cards">
            <label>Cards Accepted:</label>
            <img
              src="https://img.icons8.com/color/48/000000/paypal.png"
              alt="Paypal"
            />
            <img
              src="https://img.icons8.com/color/48/000000/mastercard-logo.png"
              alt="MasterCard"
            />
            <img
              src="https://img.icons8.com/color/48/000000/visa.png"
              alt="Visa"
            />
          </div>

          <div class="form-group">
            <label for="card-name">Name on Card:</label>
            <input type="text" id="card-name" name="card-name" required />
          </div>

          <div class="form-group">
            <label for="card-number">Credit Card Number:</label>
            <input
              type="text"
              id="card-number"
              name="card-number"
              placeholder="XXXX-XXXX-XXXX-XXXX"
              required
            />
          </div>

          <div class="form-group">
            <label for="exp-month">Exp Month:</label>
            <input type="text" id="exp-month" name="exp-month" required />
          </div>

          <div class="form-group">
            <label for="exp-year">Exp Year:</label>
            <input type="number" id="exp-year" name="exp-year" required />
          </div>

          <div class="form-group">
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" required />
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <button class="proceed-btn">Proceed To Checkout</button>
    </div>

    <button class="proceed-btn"><a href="index.php">Back to Home</a></button>
</div>

    <!-- Optional JavaScript (For Validation or Further Functionality) -->
    <script>
      // Add any form validation or processing here if needed
    </script>
  </body>
</html>
