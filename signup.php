<?php
include 'connection.php'; // Assuming this file contains your DB connection code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $userType = $_POST['userType'] ?? '';

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($userType)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and execute the SQL query
    $sql = "INSERT INTO users (username, email, password, userType) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $username, $email, $hashedPassword, $userType);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User successfully registered!']);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - The Gallery Café</title>
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Helvetica Neue', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            color: #333;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
        }

        .signup-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .signup-container h1 {
            margin-bottom: 20px;
            font-size: 2rem;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: #555;
        }

        input, select {
            width: calc(100% - 20px);
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            color: #333;
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.02);
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
            display: block;
            margin-top: 10px;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        .error {
            color: #e74c3c;
            font-size: 0.9rem;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>
        <form id="signupForm" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <div id="usernameError" class="error"></div>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <div id="emailError" class="error"></div>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div id="passwordError" class="error"></div>
            </div>
            <div>
                <label for="userType">User Type:</label>
                <select id="userType" name="userType" required>
                    <option value="customer">Customer</option>
                </select>
                <div id="userTypeError" class="error"></div>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <a href="login.php">Already have an account? Log in</a>
    </div>

    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var username = document.getElementById('username').value;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var userType = document.getElementById('userType').value;

            var isValid = true;

            // Clear previous error messages
            document.getElementById('usernameError').textContent = '';
            document.getElementById('emailError').textContent = '';
            document.getElementById('passwordError').textContent = '';
            document.getElementById('userTypeError').textContent = '';

            // Validation
            if (!validateUsername(username)) {
                document.getElementById('usernameError').textContent = 'Username must be at least 3 characters long.';
                isValid = false;
            }

            if (!validateEmail(email)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email address.';
                isValid = false;
            }

            if (!validatePassword(password)) {
                document.getElementById('passwordError').textContent = 'Password must be at least 6 characters long.';
                isValid = false;
            }

            if (isValid) {
                // Submit form via fetch
                fetch('signup.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        username: username,
                        email: email,
                        password: password,
                        userType: userType
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'home.php'; // Redirect to home page
                    } else {
                        alert('Signup failed: ' + data.message);
                    }
                });
            }
        });

        function validateUsername(username) {
            return username.length >= 3;
        }

        function validateEmail(email) {
            var re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            return re.test(String(email).toLowerCase());
        }

        function validatePassword(password) {
            return password.length >= 6;
        }
    </script>
</body>
</html>
