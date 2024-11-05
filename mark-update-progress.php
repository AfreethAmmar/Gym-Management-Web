<?php
// Include the database connection file
include 'connection.php';

// Check if the form has been submitted for inserting, updating, or deleting
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        // Update the progress data
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $clientName = mysqli_real_escape_string($conn, $_POST['client-name']);
        $nic = mysqli_real_escape_string($conn, $_POST['nic']);
        $month = mysqli_real_escape_string($conn, $_POST['month']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);

        // Update the progress in the database
        $sql = "UPDATE mark_client_progress SET client_name='$clientName', nic='$nic', month='$month', weight='$weight' WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Progress successfully updated!'); window.location.href = 'mark-update-progress.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete'])) {
        // Delete the progress data
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        // Delete from the database
        $sql = "DELETE FROM mark_client_progress WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Progress successfully deleted!'); window.location.href = 'mark-update-progress.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // Insert new progress data
        $clientName = mysqli_real_escape_string($conn, $_POST['client-name']);
        $nic = mysqli_real_escape_string($conn, $_POST['nic']);
        $month = mysqli_real_escape_string($conn, $_POST['month']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);

        // Insert into the database
        $sql = "INSERT INTO mark_client_progress (client_name, nic, month, weight) 
                VALUES ('$clientName', '$nic', '$month', '$weight')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Progress successfully saved!'); window.location.href = 'mark-update-progress.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Fetch all progress details from the database
$sql = "SELECT * FROM mark_client_progress";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Progress</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ffffff;
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: #ffffff;
        }

        th {
            background-color: #6f0f15;
        }

        td {
            background-color: #81656570;
        }

        .button-update {
            background-color: #4CAF50; /* Green */
        }

        .button-delete {
            background-color: #f44336; /* Red */
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #816565;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
        }

        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #ffb9be;
            cursor: pointer;
        }
    </style>
</head>
<body>
<a href="mark-progress-traking.php" class="button">Back to Dashboard</a>
    <div class="container">
        <h1>Update Client Progress</h1>
        <form action="mark-update-progress.php" method="POST">
            <label for="client-name">Client Name:</label>
            <input type="text" id="client-name" name="client-name" required>

            <label for="nic">NIC:</label>
            <input type="text" id="nic" name="nic" required>

            <label for="month">Month:</label>
            <input type="month" id="month" name="month" required>

            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" step="0.1" required>

            <button type="submit" class="button">Save Progress</button>
        </form>
    </div>
        
    <!-- Client Progress Details Section -->
    <div class="container">
        <h1>Client Progress Details</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>NIC</th>
                    <th>Month</th>
                    <th>Weight (kg)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['client_name'] . "</td>
                                <td>" . $row['nic'] . "</td>
                                <td>" . $row['month'] . "</td>
                                <td>" . $row['weight'] . "</td>
                                <td>
                                    <button class='button-update' onclick='openModal(" . $row['id'] . ", \"" . $row['client_name'] . "\", \"" . $row['nic'] . "\", \"" . $row['month'] . "\", \"" . $row['weight'] . "\")'>Update</button>
                                    <form action='emily-update-progress.php' method='POST' style='display:inline;'>
                                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                                        <button type='submit' name='delete' class='button-delete'>Delete</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No progress data found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Update Client Progress</h2>
            <form action="mark-update-progress.php" method="POST">
                <input type="hidden" id="update-id" name="id">
                <label for="client-name">Client Name:</label>
                <input type="text" id="update-client-name" name="client-name" required>

                <label for="nic">NIC:</label>
                <input type="text" id="update-nic" name="nic" required>

                <label for="month">Month:</label>
                <input type="month" id="update-month" name="month" required>

                <label for="weight">Weight (kg):</label>
                <input type="number" id="update-weight" name="weight" step="0.1" required>

                <button type="submit" name="update" class="button">Update Progress</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, clientName, nic, month, weight) {
            document.getElementById('update-id').value = id;
            document.getElementById('update-client-name').value = clientName;
            document.getElementById('update-nic').value = nic;
            document.getElementById('update-month').value = month;
            document.getElementById('update-weight').value = weight;

            document.getElementById('updateModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('updateModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('updateModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>
