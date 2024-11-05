<?php
// Include the database connection file
include 'connection.php';

// Check if the form has been submitted for adding a new goal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    // Retrieve the form data
    $clientName = mysqli_real_escape_string($conn, $_POST['client-name']);
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);
    $startDate = mysqli_real_escape_string($conn, $_POST['start-date']);
    $startWeight = mysqli_real_escape_string($conn, $_POST['start-weight']);
    $endDate = mysqli_real_escape_string($conn, $_POST['end-date']);
    $goalWeight = mysqli_real_escape_string($conn, $_POST['goal-weight']);

    // Insert the goal into the database
    $sql = "INSERT INTO james_fitness_goals (client_name, nic, start_date, start_weight, end_date, goal_weight) 
            VALUES ('$clientName', '$nic', '$startDate', '$startWeight', '$endDate', '$goalWeight')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Goal successfully saved!'); window.location.href = 'james-set-goal.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if the form has been submitted for updating an existing goal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Retrieve the form data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $clientName = mysqli_real_escape_string($conn, $_POST['client-name']);
    $nic = mysqli_real_escape_string($conn, $_POST['nic']);
    $startDate = mysqli_real_escape_string($conn, $_POST['start-date']);
    $startWeight = mysqli_real_escape_string($conn, $_POST['start-weight']);
    $endDate = mysqli_real_escape_string($conn, $_POST['end-date']);
    $goalWeight = mysqli_real_escape_string($conn, $_POST['goal-weight']);

    // Update the goal in the database
    $sql = "UPDATE james_fitness_goals SET 
            client_name='$clientName', nic='$nic', start_date='$startDate', start_weight='$startWeight', 
            end_date='$endDate', goal_weight='$goalWeight' 
            WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Goal successfully updated!'); window.location.href = 'james-set-goal.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Check if a goal needs to be deleted
if (isset($_GET['delete'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    $sql = "DELETE FROM james_fitness_goals WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Goal successfully deleted!'); window.location.href = 'james-set-goal.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Retrieve all fitness goals from the database
$result = mysqli_query($conn, "SELECT * FROM james_fitness_goals");

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Goal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add your existing CSS here */
        /* ... */
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url(images/staffback3.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #81656570;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #ffb9be;
            padding-bottom: 20px;
        }

        label {
            color: #ffffff;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #6f0f15;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            width: 100%;
        }

        .button:hover {
            background-color: #ffb9be;
        }

        /* Table styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px; /* More padding for better spacing */
    text-align: left; /* Align text to the left */
    border-bottom: 1px solid #ddd; /* Light gray border for separation */
    color: white;
}

th {
    background-color: #6f0f15; /* Blue background for header */
    color: white; /* White text for header */
}

tr:hover {
    background-color: black; /* Light gray on row hover */
}

/* Button styles */
button {
    background-color: #28a745; /* Green background for buttons */
    color: white; /* White text */
    border: none; /* Remove border */
    border-radius: 4px; /* Rounded corners */
    padding: 8px 12px; /* Padding for buttons */
    cursor: pointer; /* Pointer cursor on hover */
    font-size: 14px; /* Font size */
    transition: background-color 0.3s; /* Transition for hover effect */
}

button:hover {
    background-color: #218838; /* Darker green on hover */
}

/* Link styles for delete action */
a {
    color: #dc3545; /* Red color for delete links */
    text-decoration: none; /* Remove underline */
    padding: 8px 12px; /* Padding for clickable area */
    border-radius: 4px; /* Rounded corners */
}

a:hover {
    background-color: #f8d7da; /* Light red background on hover */
}

/* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.5); /* Black with opacity */
}

.modal-content {
    background-color: #fff; /* White background for modal */
    margin: 15% auto; /* Center the modal */
    padding: 20px; /* Padding inside modal */
    border: 1px solid #888; /* Border */
    width: 80%; /* Could be more or less, depending on screen size */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); /* Shadow effect */
}

.close {
    color: #aaa; /* Gray close button */
    float: right; /* Float to the right */
    font-size: 28px; /* Font size */
    font-weight: bold; /* Bold */
}

.close:hover,
.close:focus {
    color: black; /* Change color on hover */
    text-decoration: none; /* Remove underline */
    cursor: pointer; /* Pointer cursor */
}

    </style>
</head>
<body>
<a href="james-Progress-tracking-page.php" class="button">Back to Dashboard</a>
<div class="container">
    <h1>Set Fitness Goals</h1>
    
    <form method="POST" action="james-set-goal.php">
        <label for="client-name">Client Name:</label>
        <input type="text" name="client-name" required>

        <label for="nic">NIC:</label>
        <input type="text" name="nic" required>

        <label for="start-date">Start Date:</label>
        <input type="date" name="start-date" required>

        <label for="start-weight">Start Weight:</label>
        <input type="number" name="start-weight" required>

        <label for="end-date">End Date:</label>
        <input type="date" name="end-date" required>

        <label for="goal-weight">Goal Weight:</label>
        <input type="number" name="goal-weight" required>

        <button type="submit" name="save" class="button">Save Goal</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Client Name</th>
                <th>NIC</th>
                <th>Start Date</th>
                <th>Start Weight</th>
                <th>End Date</th>
                <th>Goal Weight</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['client_name']; ?></td>
                        <td><?php echo $row['nic']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <td><?php echo $row['start_weight']; ?></td>
                        <td><?php echo $row['end_date']; ?></td>
                        <td><?php echo $row['goal_weight']; ?></td>
                        <td>
                            <button onclick="openEditModal('<?php echo $row['id']; ?>', '<?php echo $row['client_name']; ?>', '<?php echo $row['nic']; ?>', '<?php echo $row['start_date']; ?>', '<?php echo $row['start_weight']; ?>', '<?php echo $row['end_date']; ?>', '<?php echo $row['goal_weight']; ?>')">Edit</button>
                            <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this goal?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No goals found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Goal</h2>
        <form method="POST" action="james-set-goal.php">
            <input type="hidden" id="edit-id" name="id">
            <label for="edit-client-name">Client Name:</label>
            <input type="text" id="edit-client-name" name="client-name" required>

            <label for="edit-nic">NIC:</label>
            <input type="text" id="edit-nic" name="nic" required>

            <label for="edit-start-date">Start Date:</label>
            <input type="date" id="edit-start-date" name="start-date" required>

            <label for="edit-start-weight">Start Weight:</label>
            <input type="number" id="edit-start-weight" name="start-weight" required>

            <label for="edit-end-date">End Date:</label>
            <input type="date" id="edit-end-date" name="end-date" required>

            <label for="edit-goal-weight">Goal Weight:</label>
            <input type="number" id="edit-goal-weight" name="goal-weight" required>

            <button type="submit" name="update" class="button">Update Goal</button>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, clientName, nic, startDate, startWeight, endDate, goalWeight) {
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-client-name').value = clientName;
        document.getElementById('edit-nic').value = nic;
        document.getElementById('edit-start-date').value = startDate;
        document.getElementById('edit-start-weight').value = startWeight;
        document.getElementById('edit-end-date').value = endDate;
        document.getElementById('edit-goal-weight').value = goalWeight;
        
        // Show the modal
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        // Hide the modal
        document.getElementById('editModal').style.display = 'none';
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == document.getElementById('editModal')) {
            closeEditModal();
        }
    }
</script>

</body>
</html>
