<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";  // Use your actual password
$dbname = "gymtrack";  // Use your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Delete Request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete_sql = "DELETE FROM bmi_strength_training WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Handle Edit Request
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $bmi = $_POST['bmi'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $session_date = $_POST['session_date'];
    $recommendations = $_POST['recommendations'];

    $edit_sql = "UPDATE bmi_strength_training SET name=?, age=?, gender=?, height=?, weight=?, bmi=?, address=?, phone=?, session_date=?, recommendations=? WHERE id=?";
    $stmt = $conn->prepare($edit_sql);
    $stmt->bind_param("sississsssi", $name, $age, $gender, $height, $weight, $bmi, $address, $phone, $session_date, $recommendations, $id);
    $stmt->execute();
    $stmt->close();
}

// Query to fetch details from bmi_records table
$sql = "SELECT id, name, age, gender, height, weight, bmi, address, phone, session_date, recommendations FROM bmi_strength_training";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client information</title>
    <style>
      body {
    font-family: Arial, sans-serif;
    background-image:  url(images/back5.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    margin: 0;
    padding: 0;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    padding-top: 100px;
    padding-bottom: 100%;
}


.header {
    text-align: center;
    margin-bottom: 20px;
}

.header h1 {
    font-size: 28px;
    color: #fff;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
    background-color: #380808e6;
}

td {
    color: white;
}

table th {
    background-color: #ff000094;
    color: white;
}

table tr:nth-child(even) {
    background-color: #f2f2f257;
}

table tr:hover {
    background-color: #ddd;
}

.btn {
    padding: 8px 12px;
    margin: 0 4px;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
}

.edit-btn {
    background-color: #ae787b;
}

.delete-btn {
    background-color: #dc3545;
}

.add-btn {
    background-color: #ff000094;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    color: white;
    margin-bottom: 20px;
    display: inline-block;
}

.add-btn:hover {
    background-color: #ffb9be;
}

.back-btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #ff000094;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
}

.back-btn:hover {
    background-color: #ffb9be;
}

/* Modal styles */
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
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.form-field {
    margin-bottom: 15px;
}

.form-field label {
    display: block;
    margin-bottom: 5px;
}

.form-field input, .form-field select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Client information</h1>
        </div>

        <!-- Table for displaying BMI records -->
        <table id="bmiTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>BMI</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Session Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are results
                if ($result->num_rows > 0) {
                    // Output data for each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['age'] . '</td>';
                        echo '<td>' . $row['gender'] . '</td>';
                        echo '<td>' . $row['height'] . '</td>';
                        echo '<td>' . $row['weight'] . '</td>';
                        echo '<td>' . $row['bmi'] . '</td>';
                        echo '<td>' . $row['address'] . '</td>';
                        echo '<td>' . $row['phone'] . '</td>';
                        echo '<td>' . $row['session_date'] . '</td>'; // Display recommendations
                        echo '<td>';
                        echo '<form action="" method="post" style="display:inline;">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<button type="submit" name="delete" class="btn delete-btn">Delete</button>';
                        echo '</form>';
                        echo '<button class="btn edit-btn" onclick="openModal(' . $row['id'] . ', \'' . htmlspecialchars($row['name'], ENT_QUOTES) . '\', ' . $row['age'] . ', \'' . $row['gender'] . '\', ' . $row['height'] . ', ' . $row['weight'] . ', ' . $row['bmi'] . ', \'' . htmlspecialchars($row['address'], ENT_QUOTES) . '\', \'' . htmlspecialchars($row['phone'], ENT_QUOTES) . '\', \'' . $row['session_date'] . '\', \'' . htmlspecialchars($row['recommendations'], ENT_QUOTES) . '\')">Edit</button>'; // Include recommendations in the modal
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="12">No records found.</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <!-- Back to home page button -->
        <a href="admin_view_staff.php" class="back-btn">Back to Home</a>

        <!-- Add new BMI record button -->
        <a href="add_bmi_record.php" class="add-btn">Add New BMI Record</a>

        <!-- Edit Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Edit BMI Record</h2>
                <form action="" method="post">
                    <input type="hidden" name="id" id="editId" value="">
                    <div class="form-field">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="editName" required>
                    </div>
                    <div class="form-field">
                        <label for="age">Age:</label>
                        <input type="number" name="age" id="editAge" required>
                    </div>
                    <div class="form-field">
                        <label for="gender">Gender:</label>
                        <select name="gender" id="editGender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="height">Height (cm):</label>
                        <input type="number" name="height" id="editHeight" required>
                    </div>
                    <div class="form-field">
                        <label for="weight">Weight (kg):</label>
                        <input type="number" name="weight" id="editWeight" required>
                    </div>
                    <div class="form-field">
                        <label for="bmi">BMI:</label>
                        <input type="number" step="0.01" name="bmi" id="editBmi" required>
                    </div>
                    <div class="form-field">
                        <label for="address">Address:</label>
                        <input type="text" name="address" id="editAddress" required>
                    </div>
                    <div class="form-field">
                        <label for="phone">Phone:</label>
                        <input type="text" name="phone" id="editPhone" required>
                    </div>
                    <div class="form-field">
                        <label for="session_date">Session Date:</label>
                        <input type="date" name="session_date" id="editSessionDate" required>
                    </div>
                    <div class="form-field">
                        <label for="recommendations">Recommendations:</label>
                        <input type="text" name="recommendations" id="editRecommendations" required>
                    </div>
                    <button type="submit" name="edit" class="btn edit-btn">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to open the edit modal
        function openModal(id, name, age, gender, height, weight, bmi, address, phone, session_date, recommendations) {
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editAge').value = age;
            document.getElementById('editGender').value = gender;
            document.getElementById('editHeight').value = height;
            document.getElementById('editWeight').value = weight;
            document.getElementById('editBmi').value = bmi;
            document.getElementById('editAddress').value = address;
            document.getElementById('editPhone').value = phone;
            document.getElementById('editSessionDate').value = session_date;

            document.getElementById('editModal').style.display = 'block';
        }

        // Close the modal
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
