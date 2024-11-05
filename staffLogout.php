<?php   include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - The Gallery Café</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
         
         
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
    url(images/gymback10.jpg);
    background-repeat: no-repeat;
    background-size: cover;
        }

        .logout-box {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            background-color: #380808e6;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: white;
        }

        p {
            margin-bottom: 20px;
            font-size: 1rem;
        }

        a {
            text-decoration: none;
            color: #d8adad;
            font-weight: bold;
            font-size: 1rem;
        }

        a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>
    <div class="logout-box">
        <h1>Logout</h1>
        <p>You have successfully logged out.</p>
        <p><a href="lo.php">Click here to login again</a></p>
        <p><a href="staff_main_dashboard.php">Return to Dashboard</a></p>
    </div>

    <script>
        // Function to handle logout
        async function handleLogout() {
            try {
                const response = await fetch('/logout', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    console.log('Logged out successfully');
                } else {
                    console.error('Logout failed');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Execute logout on page load
        document.addEventListener('DOMContentLoaded', () => {
            handleLogout();
        });
    </script>
</body>
</html>
