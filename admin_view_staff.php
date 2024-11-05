<?php
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Session Schedule</title>
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: 
            url(images/back5.jpg);
      background-repeat: no-repeat;
      background-size: cover;
      margin: 0;
      padding: 0;
      color: #fff; /* White text for better visibility */
    }
    .container {
      width: 90%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
      text-align: center;
    }
    .header {
      margin-bottom: 30px;
    }
    .header h1 {
      font-size: 36px;
      color: #ffb9be; /* Soft pink color */
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Text shadow for better visibility */
    }
    .button-container {
      display: flex;
      justify-content: center;
      gap: 20px; /* Spacing between buttons */
      flex-wrap: wrap; /* Responsive layout */
    }
    .btn {
      padding: 15px 25px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
      position: relative; /* Positioning for icon */
      text-decoration: none; /* Remove underline */
      color: #fff; /* White text color */
      background-color:#b65158; /* Dark background color */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow effect */
    }
    .btn:hover {
      background-color: #ffb9be; /* Change color on hover */
    }
    .card {
      background-color: rgba(255, 255, 255, 0.1); /* Slightly transparent background for cards */
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Shadow for cards */
      transition: transform 0.2s ease; /* Smooth scale effect */
    }
    .card:hover {
      transform: scale(1.05); /* Scale effect on hover */
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Trainers</h1>
    </div>

    <!-- Trainer Cards -->
    <div class="button-container">
      <div class="card">
        <a href="James-session-manage.php" class="btn">James Rodriguez</a>
      </div>
      <div class="card">
        <a href="Mark-session-manage.php" class="btn">Mark Harris</a>
      </div>
      <div class="card">
        <a href="Emily-session-manage.php" class="btn">Emily Davis</a>
      </div>
      <div class="card">
        <a style="background-color: rgb(86 10 19);" href="admin.php" class="btn">Back</a>
      </div>
    </div>
  </div>
</body>
</html>
