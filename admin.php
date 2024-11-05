<?php

   include 'connection.php'

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="styles.css" />
    <title>Web Design Mastery | Power</title>
    <style>
        .header{
            background-color: black;
        }
        .header__content h4 {
    font-size: 2.5rem;
    font-weight: 400;
    color: #ffffff;
}
.section__header {
    position: relative;
    padding-bottom: 0.5rem;
    margin-bottom: 1rem;
    font-size: 2.25rem;
    font-weight: 600;
    color: red;
    text-align: center;
}

.btn a{
    color: white;
    font-weight: 700;
}
:root {
            --primary-color: #ebe3e3;
            --secondary-color: #cd6b09;
            --button-color:#0b0602 ;
            --button-hover-color: #45a049;
            --logout-color: #f44336;
            --logout-hover-color: #d32f2f;
            --background-gradient-start: #1e3c72;
            --background-gradient-end: #2a5298;
            --section-bg-color: rgba(255, 255, 255, 0.9);
            --section-border-radius: 8px;
            --button-radius: 5px;
            --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        * {
            box-sizing: border-box;
            font-family: var(--font-family);
            margin: 0;
            padding: 0;
           
        }
body{
    background-image:
    url(images/back5.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}
        

        h1 {
            color: var(--primary-color);
            text-align: center;
            font-size: 2rem;
            padding-top: 5%;
            margin-bottom: 20px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
        }

        .btn {
            display: inline-block;
            background-color: #f44336;;
            color: var(--primary-color);
            border: none;
            padding: 12px 24px;
            cursor: pointer;
            border-radius: var(--button-radius);
            font-size: 1rem;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none;
            margin: 10px;
            font-weight: 700;
        }

        .btn:hover {
            background-color: #ff000094;
            transform: scale(1.05);
        }

        .logout-btn {
            background-color: white;
            color: black;
            font-weight: 700;
        }
        .logout-btn:hover {
            background-color: var(--logout-hover-color);
        }

        .actions {
            text-align: center;
            margin-top: 20px;
        }

        .dashboard-section {
            background: var(--section-bg-color);
            border-radius: var(--section-border-radius);
            padding: 20px;
            margin: 10px 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dashboard-section h3 {
            color: var(--secondary-color);
            margin-bottom: 15px;
        }

        .dashboard-section button {
            background-color: var(--button-color);
            color: var(--primary-color);
            border: none;
            padding: 12px 24px;
            cursor: pointer;
            border-radius: var(--button-radius);
            font-size: 1rem;
            margin: 10px;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none;
        }

        .dashboard-section button:hover {
            background-color: var(--button-hover-color);
            transform: scale(1.05);
        }
    </style>
  </head>
  <body>

<div class="container">
    <div class="actions">th
    <a href="manageUser.php" class="btn">Manage Users</a>
    <a href="manage-menu.php" class="btn">Manage Store</a>
        <a href="gymPricing.php" class="btn">Manage Gym package </a>
        <a href="financial.php" class="btn">Financial Report</a>
        <a href="logout.php" class="btn logout-btn">Logout</a>
        <br>
        <a href="manageTrainers.php" class="btn">Manage Trainers</a>
        <a href="admin_view_staff.php" class="btn">Booked Sessions</a>
        <a href="admin-bmi.php" class="btn">Add customer</a>
        <a href="onlineOrders.php
        " class="btn">view Online Orders</a>
       
    </div>
</div>
      <div class="section__container header__container" id="home">
        <div class="header__image">
          <img src="images/R.png" alt="header" />
        </div>
        <div class="header__content">
          <h4>Welcome To <i><b>Gym Track...</b></i></h4>
          <h1 class="section__header">Admin!</h1>
        </div>
      </div>
    </header>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>
