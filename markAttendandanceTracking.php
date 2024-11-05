<?php
include 'connection.php';

// Handle attendance logging
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['edit-id'])) {
    // Retrieve the form data
    $memberId = $_POST['member-id'];
    $memberName = $_POST['member-name'];
    $checkIn = $_POST['check-in'];
    $checkOut = isset($_POST['check-out']) ? $_POST['check-out'] : null;

    // Validate that required fields are filled
    if (empty($memberId) || empty($memberName) || empty($checkIn)) {
        echo "Error: Please fill all required fields.";
        exit;
    }

    // Ensure date format is correct for MySQL by converting datetime-local input
    $checkIn = str_replace('T', ' ', $checkIn);
    if ($checkOut) {
        $checkOut = str_replace('T', ' ', $checkOut);
    }

    // Insert data into the attendance table
    $stmt = $conn->prepare("INSERT INTO mark_attendance_tracking (member_id, member_name, check_in, check_out) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $memberId, $memberName, $checkIn, $checkOut);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle attendance record update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit-id'])) {
    // Retrieve the updated form data
    $editId = $_POST['edit-id'];
    $memberId = $_POST['member-id'];
    $memberName = $_POST['member-name'];
    $checkIn = $_POST['check-in'];
    $checkOut = isset($_POST['check-out']) ? $_POST['check-out'] : null;

    // Ensure date format is correct for MySQL by converting datetime-local input
    $checkIn = str_replace('T', ' ', $checkIn);
    if ($checkOut) {
        $checkOut = str_replace('T', ' ', $checkOut);
    }

    // Update the record in the database
    $updateStmt = $conn->prepare("UPDATE mark_attendance_tracking SET member_id = ?, member_name = ?, check_in = ?, check_out = ? WHERE id = ?");
    $updateStmt->bind_param('ssssi', $memberId, $memberName, $checkIn, $checkOut, $editId);

    if ($updateStmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $updateStmt->error;
    }

    $updateStmt->close();
}

// Handle deletion of attendance records
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $deleteId = $_GET['id'];
    $deleteStmt = $conn->prepare("DELETE FROM mark_attendance_tracking WHERE id = ?");
    $deleteStmt->bind_param('i', $deleteId);

    if ($deleteStmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $deleteStmt->error;
    }

    $deleteStmt->close();
}

// Fetch attendance records from the database
$records = [];
$result = $conn->query("SELECT id, member_id, member_name, check_in, check_out FROM mark_attendance_tracking");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}
$conn->close();
?>

<?php
include 'connection.php';

// Fetch attendance records based on search query
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$records = [];

if (!empty($searchQuery)) {
    // Sanitize the search query to prevent SQL injection
    $searchQuery = "%" . $conn->real_escape_string($searchQuery) . "%";
    $stmt = $conn->prepare("SELECT id, member_id, member_name, check_in, check_out FROM mark_attendance_tracking WHERE member_id LIKE ? OR member_name LIKE ?");
    $stmt->bind_param('ss', $searchQuery, $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Default query to fetch all records
    $result = $conn->query("SELECT id, member_id, member_name, check_in, check_out FROM mark_attendance_tracking");
}

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Attendance Tracking</title>
    <link rel="stylesheet" href="styles.css">
    <style>
       body {
    font-family: Arial, sans-serif;
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(images/staffback3.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: auto;
    padding: 20px;
}

h1 {
    text-align: center;
    color: #ffb9be;
    padding-bottom: 30px;
}

.form-container, .table-container {
    background-color: #9f6161;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.form-container {
    border: 2px solid #6f0f15;
}
form{
    padding-top: 20px;
    align-items: center;

}
.popup-form {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.popup-form input {
    margin-bottom: 10px;
    width: 100%;
    padding: 10px;
}

.popup-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 500;
}

.back-button {
    padding: 10px;
    background-color: #6f0f15;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #dddddd;
    text-align: left;
}

th {
    background-color: #6f0f15;
    color: #fff;
}

.edit-btn, .delete-btn {
    padding: 5px 10px;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.edit-btn {
    background-color: #28a745;
}

.delete-btn {
    background-color: #dc3545;
}

.search-bar {
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
}

.search-bar input[type="text"] {
    padding: 15px 200px;
    width: 50%;
    border: 1px solid #6f0f15;
    border-radius: 4px;
    color: black;
}

.search-bar button {
    padding: 10px;
    background-color: #6f0f15;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 10px;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: #6f0f15;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #4b0a0f;
}

.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 100%;
    max-width: 500px;
    margin: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

label {
    font-size: 16px;
    margin-bottom: 5px;
    color: #6f0f15;
}

input[type="text"],
input[type="datetime-local"] {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 100%;
    font-size: 14px;
}

input:focus {
    border-color: #6f0f15;
    outline: none;
}

button[type="submit"] {
    padding: 12px;
    background-color: #6f0f15;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #4b0a0f;
}

@media screen and (max-width: 600px) {
    .form-container {
        width: 90%;
        padding: 15px;
    }

    input[type="text"],
    input[type="datetime-local"] {
        font-size: 14px;
    }
}


    </style>
</head>
<body>
    <div class="container">
        <a href="markStaffDashboard.php" class="back-button">Back to Dashboard</a>
        <h1>Member Attendance Tracking</h1>

        <!-- Form for logging attendance -->
        <div class="form-container">
            <h2>Log Attendance</h2>
            <form id="attendance-form" method="POST">
                <label for="member-id">Member ID:</label>
                <input type="text" id="member-id" name="member-id" required>

                <label for="member-name">Member Name:</label>
                <input type="text" id="member-name" name="member-name" required>

                <label for="check-in">Check-In Time:</label>
                <input type="datetime-local" id="check-in" name="check-in" required>

                <label for="check-out">Check-Out Time:</label>
                <input type="datetime-local" id="check-out" name="check-out">

                <button type="submit">Log Attendance</button>
            </form>
        </div>
        <div class="search-bar">
    <form method="GET" action="">
        <input style="color: black;" type="text" name="search" placeholder="Search by Member ID or Name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">Search</button>
    </form>
</div>

        <!-- Table for displaying attendance records -->
        <div class="table-container">
            <h2>Attendance Records</h2>
            <table id="attendance-table">
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <th>Check-In Time</th>
                        <th>Check-Out Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $row): ?>
                    <tr data-id="<?php echo $row['id']; ?>">
                        <td><?php echo htmlspecialchars($row['member_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['member_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['check_in']); ?></td>
                        <td><?php echo htmlspecialchars($row['check_out']); ?></td>
                        <td>
                            <button class="edit-btn" onclick="openEditForm(<?php echo $row['id']; ?>)">Edit</button>
                            <button class="delete-btn" onclick="deleteRecord(<?php echo $row['id']; ?>)">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Popup form for editing attendance -->
        <div class="popup-overlay" id="popup-overlay"></div>
        <div class="popup-form" id="popup-form">
            <h2>Edit Attendance</h2>
            <form id="edit-attendance-form" method="POST">
                <input type="hidden" id="edit-id" name="edit-id">

                <label for="edit-member-id">Member ID:</label>
                <input type="text" id="edit-member-id" name="member-id" required>

                <label for="edit-member-name">Member Name:</label>
                <input type="text" id="edit-member-name" name="member-name" required>

                <label for="edit-check-in">Check-In Time:</label>
                <input type="datetime-local" id="edit-check-in" name="check-in" required>

                <label for="edit-check-out">Check-Out Time:</label>
                <input type="datetime-local" id="edit-check-out" name="check-out">

                <button type="submit">Save Changes</button>
                <button type="button" onclick="closeEditForm()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function openEditForm(id) {
            // Populate form with current values
            const row = document.querySelector(`tr[data-id='${id}']`);
            const memberId = row.children[0].textContent;
            const memberName = row.children[1].textContent;
            const checkIn = row.children[2].textContent.replace(' ', 'T');
            const checkOut = row.children[3].textContent.replace(' ', 'T');

            document.getElementById('edit-id').value = id;
            document.getElementById('edit-member-id').value = memberId;
            document.getElementById('edit-member-name').value = memberName;
            document.getElementById('edit-check-in').value = checkIn;
            document.getElementById('edit-check-out').value = checkOut || '';

            // Show the popup form
            document.getElementById('popup-form').style.display = 'block';
            document.getElementById('popup-overlay').style.display = 'block';
        }

        function closeEditForm() {
            document.getElementById('popup-form').style.display = 'none';
            document.getElementById('popup-overlay').style.display = 'none';
        }

        function deleteRecord(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "?action=delete&id=" + id;
            }
        }
    </script>
    <script>
    document.querySelector('input[name="search"]').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#attendance-table tbody tr');

        rows.forEach(function (row) {
            const memberId = row.children[0].textContent.toLowerCase();
            const memberName = row.children[1].textContent.toLowerCase();

            if (memberId.includes(searchValue) || memberName.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>
