<?php
include 'connection.php';

// Add a new user to the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, userType) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        echo "User added successfully.";
    } else {
        echo "Error adding user: " . $stmt->error;
    }

    $stmt->close();
}

// Edit a user in the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Update user in the database
    $query = "UPDATE users SET username = ?, email = ?, userType = ?";
    if ($password) {
        $query .= ", password = ?";
    }
    $query .= " WHERE id = ?";

    $stmt = $conn->prepare($query);
    if ($password) {
        $stmt->bind_param("ssssi", $name, $email, $role, $password, $id);
    } else {
        $stmt->bind_param("sssi", $name, $email, $role, $id);
    }

    if ($stmt->execute()) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
}

// Delete a user from the database
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "User deleted successfully.";
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch users by role from the database
$users = [
    'admin' => [],
    'customer' => [],
    'staff' => []
];

$result = $conn->query("SELECT * FROM users");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[$row['userType']][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - The Gallery Café</title>
    <style>
         /* Basic reset */
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('admin1.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            padding: 20px;
            background-image:
            url(images/back5.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }

        header {
            background: rgba(0, 0, 0, 0.7);
            color: #d4a373;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            color: #ffffffa1;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: #ffffffa1;
            text-decoration: none;
            font-size: 1rem;
        }

        section {
            background: #380808e6;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            margin-bottom: 20px;
            color: #ffffffa1;
            font-size: 1.8rem;
            text-align: center;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 1rem;
        }

        table thead tr {
            background-color: #ff000094;
            color: #fff;
        }

        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
            color: white;
        }

        button {
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1rem;
            margin: 10px 0;
            transition: background-color 0.3s;
        }

        .add-user-button {
            background-color:#ff000094;
            color: #fff;
        }

        .edit-button {
            background-color: #185ec1;
            color: #fff;
        }

        .delete-button {
            background-color: #dc3545;
            color: #fff;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        form label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        form input, form select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        
        .close-btn {
            float: right;
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Manage Users</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>
    
    <section>
        <h2>Admin Users</h2>
        <table id="adminUsersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users['admin'] as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo ucfirst($user['userType']); ?></td>
                        <td>
                            <a href="#" class="edit-button" data-id="<?php echo $user['id']; ?>" data-username="<?php echo $user['username']; ?>" data-email="<?php echo $user['email']; ?>" data-role="<?php echo $user['userType']; ?>">Edit</a>
                            <a href="?delete=<?php echo $user['id']; ?>" class="delete-button">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Customer Users</h2>
        <table id="customerUsersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users['customer'] as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo ucfirst($user['userType']); ?></td>
                        <td>
                            <a href="#" class="edit-button" data-id="<?php echo $user['id']; ?>" data-username="<?php echo $user['username']; ?>" data-email="<?php echo $user['email']; ?>" data-role="<?php echo $user['userType']; ?>">Edit</a>
                            <a href="?delete=<?php echo $user['id']; ?>" class="delete-button">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Staff Users</h2>
        <table id="staffUsersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users['staff'] as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo ucfirst($user['userType']); ?></td>
                        <td>
                            <a href="#" class="edit-button" data-id="<?php echo $user['id']; ?>" data-username="<?php echo $user['username']; ?>" data-email="<?php echo $user['email']; ?>" data-role="<?php echo $user['userType']; ?>">Edit</a>
                            <a href="?delete=<?php echo $user['id']; ?>" class="delete-button">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <button id="addUserBtn" class="add-user-button">Add User</button>

    <!-- Add/Edit User Modal (same as before) -->
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Add User</h2>
            <form id="userForm" method="POST">
                <input type="hidden" name="id" id="userId">
                <label for="userName">Name:</label>
                <input type="text" id="userName" name="name" required>

                <label for="userEmail">Email:</label>
                <input type="email" id="userEmail" name="email" required>

                <label for="userRole">Role:</label>
                <select id="userRole" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="customer">Customer</option>
                    <option value="staff">Staff</option>
                </select>

                <label for="userPassword">Password:</label>
                <input type="password" id="userPassword" name="password">

                <input type="hidden" name="action" id="action" value="add">
                <button type="submit" class="add-user-button">Submit</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('addUserBtn').onclick = function() {
            document.getElementById('userModal').style.display = 'flex';
            document.getElementById('userForm').reset();
            document.getElementById('action').value = 'add';
        };

        document.querySelectorAll('.edit-button').forEach(button => {
            button.onclick = function() {
                document.getElementById('userModal').style.display = 'flex';
                document.getElementById('userId').value = this.dataset.id;
                document.getElementById('userName').value = this.dataset.username;
                document.getElementById('userEmail').value = this.dataset.email;
                document.getElementById('userRole').value = this.dataset.role;
                document.getElementById('action').value = 'edit';
            };
        });

        document.querySelector('.close-btn').onclick = function() {
            document.getElementById('userModal').style.display = 'none';
        };
    </script>
</body>
</html>
