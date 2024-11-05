<?php
include 'connection.php';
session_start();

// Function to show alert
function showAlert($title, $message) {
  echo "<script>
          document.addEventListener('DOMContentLoaded', function() {
            var alertModal = document.getElementById('alertModal');
            document.getElementById('alertTitle').innerText = '$title';
            document.getElementById('alertMessage').innerText = '$message';
            alertModal.style.display = 'flex';
            setTimeout(() => {
              alertModal.style.opacity = '1';
            }, 0);
          });
        </script>";
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Hard-coded credentials for James, Mark, and Emily
  if ($username == 'James' && $password == 'james123') {
    $_SESSION['username'] = $username;
    header('Location: jamesStaffdashboard.php'); // Redirect to James' dashboard
    exit();
  } elseif ($username == 'Mark' && $password == 'mark123') {
    $_SESSION['username'] = $username;
    header('Location: markStaffDashboard.php'); // Redirect to Mark's dashboard
    exit();
  } elseif ($username == 'Emily' && $password == 'emily123') {
    $_SESSION['username'] = $username;
    header('Location: emilyStaffDashbord.php'); // Redirect to Emily's dashboard
    exit();
  } else {
    // Show alert for invalid credentials
    showAlert('Login Failed', 'Invalid credentials, please try again.');
  }
}
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
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(images/gymback10.jpg);
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

    .header span {
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
      transition: background-color 0.3s, transform 0.2s ease;
      cursor: pointer;
    }

    .nav-buttons a:hover {
      background-color: #ffb9be;
      transform: scale(1.05);
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

    /* Animation for modal fade-in */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      animation: fadeIn 0.3s ease-in-out;
    }

    .modal-content {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      width: 300px;
      box-shadow: 0px 0px 10px #000;
      text-align: center;
    }

    .close {
      float: right;
      font-size: 24px;
      cursor: pointer;
    }

    .modal-header {
      font-size: 22px;
      margin-bottom: 10px;
    }

    .modal-footer {
      margin-top: 20px;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    button {
      padding: 10px 20px;
      background-color: #6f0f15;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s, transform 0.2s ease;
    }

    button:hover {
      background-color: #ffb9be;
      transform: scale(1.05);
    }

    /* Custom alert modal */
    .alert-modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 9999; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Black background with transparency */
      justify-content: center;
      align-items: center;
      animation: fadeIn 0.3s ease-in-out;
    }

    .alert-content {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      width: 300px;
      text-align: center;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }

    .alert-content h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .alert-content p {
      font-size: 18px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Welcome to <span>Staff Dashboard</span></h1>
    </div>

    <div class="nav-buttons">
      <a href="#" id="jamesLoginBtn">James Rodriguez</a>
      <a href="#" id="markLoginBtn">Mark Harris</a>
      <a href="#" id="emilyLoginBtn">Emily Davis</a>
      <a style="background-color: #ffb9be;" href="staff-bmi.php">Add customer</a>
      <a style="background-color: #ffb9be;" href="staffLogout.php">Logout</a>
    </div>
  </div>

  <div class="section_container header_container" id="home">
    <div class="header__image">
      <img src="images/R.png" alt="header" />
    </div>
  </div>

  <!-- James Login Modal -->
  <div id="jamesLoginModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('jamesLoginModal')">&times;</span>
      <div class="modal-header">Login - James Rodriguez</div>
      
      <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="James" readonly>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>

  <!-- Mark Login Modal -->
  <div id="markLoginModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('markLoginModal')">&times;</span>
      <div class="modal-header">Login - Mark Harris</div>
      
      <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="Mark" readonly>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>

  <!-- Emily Login Modal -->
  <div id="emilyLoginModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal('emilyLoginModal')">&times;</span>
      <div class="modal-header">Login - Emily Davis</div>
      
      <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="Emily" readonly>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>

  <!-- Alert Modal -->
  <div id="alertModal" class="alert-modal">
    <div class="alert-content">
      <span class="close" onclick="closeAlert()">&times;</span>
      <h2 id="alertTitle"></h2>
      <p id="alertMessage"></p>
    </div>
  </div>

  <footer>
    <p>&copy; 2024 Staff Dashboard. All rights reserved.</p>
  </footer>

  <script>
    // Open modals
    document.getElementById('jamesLoginBtn').onclick = function() {
      document.getElementById('jamesLoginModal').style.display = 'flex';
    }
    document.getElementById('markLoginBtn').onclick = function() {
      document.getElementById('markLoginModal').style.display = 'flex';
    }
    document.getElementById('emilyLoginBtn').onclick = function() {
      document.getElementById('emilyLoginModal').style.display = 'flex';
    }

    // Close modals
    function closeModal(modalId) {
      document.getElementById(modalId).style.display = 'none';
    }

    // Close alert modal
    function closeAlert() {
      var alertModal = document.getElementById('alertModal');
      alertModal.style.opacity = '0';
      setTimeout(() => {
        alertModal.style.display = 'none';
      }, 300);
    }
  </script>
</body>
</html>
