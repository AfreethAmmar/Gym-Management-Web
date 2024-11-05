<?php    include 'connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Dashboard - Home</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
    url(images/staffback3.jpg);
    background-repeat: no-repeat;
    background-size: cover;
     
    }

    .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 40px;
    }

    .header h1 {
      font-size: 32px;
      color: #ffffff;
    }
    .header span{
        color: #ffb9be;
    }
    .nav-buttons {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    .nav-buttons a {
      display: block;
      width: 200px;
      padding: 15px;
      margin: 10px;
      text-align: center;
      text-decoration: none;
      background-color: #6f0f15;
      color: white;
      border-radius: 5px;
      font-size: 18px;
      transition: background-color 0.3s;
    }

    .nav-buttons a:hover {
      background-color:#ffb9be;
    }

    footer {
      text-align: center;
      margin-top: 40px;
    }



    
.header__image img {
    max-width: 500px;
    margin: auto;
}
img {
    display: flex;
    width: 100%;
}
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Welcome  <span> Emily Davis </span></h1>
    </div>

    <div class="nav-buttons">
      <a href="emilyViewSesson.php">View Session Schedule</a>
      <a href="emilyAttendenceTracking.php">Attendance Tracking</a>
      <a href="emily-progress-tracking.php">Progress Tracking</a>
      <br>
      <a href="staff_main_dashboard.php">Back</a>
    </div>
  </div>

  <div class="section__container header__container" id="home">
        <div class="header__image">
          <img src="images/R.png" alt="header" />
        </div>
        
      </div>
</body>
</html>
