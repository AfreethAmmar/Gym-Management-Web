<?php

   include 'connection.php'

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Confirm Your Payment</title>
    <style>
      body {
        font-family: "Arial", sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }

      .payment-form {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        width: 400px;
      }

      .payment-form h2 {
        text-align: center;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
      }

      .form-group {
        margin-bottom: 15px;
      }

      .form-group label {
        display: block;
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
      }

      .form-group input[type="text"],
      .form-group input[type="number"] {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 16px;
      }

      .form-group-inline {
        display: flex;
        justify-content: space-between;
      }

      .form-group-inline .form-group {
        width: 48%;
      }

      .cards {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px 0;
      }

      .cards img {
        margin-right: 10px;
        width: 50px;
      }

      .expiration-date {
        display: flex;
        justify-content: space-between;
      }

      .expiration-date select {
        width: 48%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 16px;
      }

      .confirm-btn {
        width: 100%;
        padding: 15px;
        background-color: #8000ff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        margin-top: 20px;
      }

      .confirm-btn:hover {
        background-color: #6b00cc;
      }

      .back-btn{
        width: 100%;
        padding: 15px;
        background-color: #8000ff;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        cursor: pointer;
        margin-top: 20px;
      }

      .back-btn a{
        text-decoration: none;
        color: white;
      }
    </style>
  </head>
  <body>
    <div class="payment-form">
      <h2>Confirm Your Payment</h2>

      <div class="form-group">
        <label for="owner">Owner</label>
        <input
          type="text"
          id="owner"
          name="owner"
          placeholder="Enter card owner"
        />
      </div>

      <div class="form-group-inline">
        <div class="form-group">
          <label for="card-number">Card Number</label>
          <input
            type="text"
            id="card-number"
            name="card-number"
            placeholder="XXXX-XXXX-XXXX-XXXX"
          />
        </div>

        <div class="form-group">
          <label for="cvv">CVV</label>
          <input type="number" id="cvv" name="cvv" placeholder="CVV" />
        </div>
      </div>

      <div class="expiration-date">
        <select name="exp-month" id="exp-month">
          <option value="Jan">Jan</option>
          <option value="Feb">Feb</option>
          <option value="Mar">Mar</option>
          <option value="Apr">Apr</option>
          <option value="May">May</option>
          <option value="Jun">Jun</option>
          <option value="Jul">Jul</option>
          <option value="Aug">Aug</option>
          <option value="Sep">Sep</option>
          <option value="Oct">Oct</option>
          <option value="Nov">Nov</option>
          <option value="Dec">Dec</option>
        </select>

        <select name="exp-year" id="exp-year">
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>
          <option value="2027">2027</option>
        </select>
      </div>

      <div class="cards">
        <img
          src="https://img.icons8.com/color/48/000000/mastercard-logo.png"
          alt="MasterCard"
        />
        <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" />
        <img
          src="https://img.icons8.com/color/48/000000/paypal.png"
          alt="Paypal"
        />
      </div>

      <button class="confirm-btn">Confirm</button>

      <button class="back-btn"><a href="index.php">Back to Home</a></button>
    </div>

    <!-- Optional JavaScript (If needed for form validation or submission) -->
    <script>
      document
        .querySelector(".confirm-btn")
        .addEventListener("click", function () {
          alert("Payment confirmed!");
        });
    </script>
  </body>
</html>
