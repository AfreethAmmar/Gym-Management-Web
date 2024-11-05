<?php
// Include your database connection file
include 'connection.php';

// Fetch session bookings from the database
$query = "SELECT * FROM sessonbookings";
$result = $conn->query($query);

// Handle form submission for adding or updating a session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['editId'])) {
        // Update existing session
        $sessionId = $_POST['editId'];
        $sessionName = $_POST['sessionName'];
        $sessionDate = $_POST['sessionDate'];
        $sessionTime = $_POST['sessionTime'];
        $classType = $_POST['classType'];

        $sql = "UPDATE sessonbookings SET name='$sessionName', date='$sessionDate', time='$sessionTime', class_type='$classType' WHERE id='$sessionId'";
        if ($conn->query($sql) === TRUE) {
            echo "Session updated successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Insert new session
        $sessionName = $_POST['sessionName'];
        $sessionDate = $_POST['sessionDate'];
        $sessionTime = $_POST['sessionTime'];
        $classType = $_POST['classType'];

        $sql = "INSERT INTO sessonbookings (name, date, time, class_type) VALUES ('$sessionName', '$sessionDate', '$sessionTime', '$classType')";
        if ($conn->query($sql) === TRUE) {
            echo "New session added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Handle session deletion
if (isset($_GET['delete_id'])) {
    $sessionId = $_GET['delete_id'];
    $sql = "DELETE FROM sessonbookings WHERE id='$sessionId'";
    if ($conn->query($sql) === TRUE) {
        echo "Session deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Session Schedule</title>
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
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
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
    }
    table th {
      background-color: #ffb9be;
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
      background-color: #6f0f15;
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
      background-color: #6f0f15;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .back-btn:hover {
      background-color: #ffb9be;
    }
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 5px;
      width: 300px;
      text-align: center;
    }
    .modal input {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .close-btn {
      background-color: #dc3545;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .save-btn {
      background-color: #28a745;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    footer {
      text-align: center;
      margin-top: 40px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Session Schedule</h1>
    </div>

    <!-- Add Session Button -->
    <a href="#" class="add-btn" onclick="openAddModal()">Add Session</a>

    <!-- Table for displaying session schedules -->
    <table id="sessionTable">
      <thead>
        <tr>
          <th>Session ID</th>
          <th>Session Name</th>
          <th>Date</th>
          <th>Time</th>
          <th>Class Type</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['name'] . '</td>';
                echo '<td>' . $row['date'] . '</td>';
                echo '<td>' . $row['time'] . '</td>';
                echo '<td>' . $row['class_type'] . '</td>';
                echo '<td>';
                echo '<button class="btn edit-btn" onclick="openEditModal(' . $row['id'] . ', \'' . $row['name'] . '\', \'' . $row['date'] . '\', \'' . $row['time'] . '\', \'' . $row['class_type'] . '\')">Edit</button>';
                echo '<button class="btn delete-btn" onclick="deleteSession(' . $row['id'] . ')">Delete</button>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">No sessions found.</td></tr>';
        }
        ?>
      </tbody>
    </table>

    <!-- Back to home page button -->
    <a href="staffDashboard.php" class="back-btn">Back to Dashboard</a>
  </div>

  <!-- Modal for adding/editing session -->
  <div class="modal" id="sessionModal">
    <div class="modal-content">
      <h2 id="modalTitle">Add New Session</h2>
      <form action="" method="POST">
        <input type="hidden" id="editId" name="editId">
        <input type="text" id="sessionName" name="sessionName" placeholder="Session Name" required>
        <input type="date" id="sessionDate" name="sessionDate" required>
        <input type="time" id="sessionTime" name="sessionTime" required>
        <input type="text" id="classType" name="classType" placeholder="Class Type" required>
        <button type="submit" class="save-btn">Save</button>
        <button type="button" class="close-btn" onclick="closeModal()">Close</button>
      </form>
    </div>
  </div>

  <script>
    function openAddModal() {
      document.getElementById('sessionModal').style.display = 'flex';
      document.getElementById('modalTitle').textContent = "Add New Session";
      document.getElementById('editId').value = '';
      document.getElementById('sessionName').value = '';
      document.getElementById('sessionDate').value = '';
      document.getElementById('sessionTime').value = '';
      document.getElementById('classType').value = '';
    }

    function openEditModal(id, name, date, time, classType) {
      document.getElementById('sessionModal').style.display = 'flex';
      document.getElementById('modalTitle').textContent = "Edit Session";
      document.getElementById('editId').value = id;
      document.getElementById('sessionName').value = name;
      document.getElementById('sessionDate').value = date;
      document.getElementById('sessionTime').value = time;
      document.getElementById('classType').value = classType;
    }

    function closeModal() {
      document.getElementById('sessionModal').style.display = 'none';
    }

    function deleteSession(id) {
      if (confirm("Are you sure you want to delete this session?")) {
        window.location.href = "?delete_id=" + id;
      }
    }
  </script>
</body>
</html>
