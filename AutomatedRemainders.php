<?php    include 'connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automated Reminders</title>
    <link rel="stylesheet" href="styles.css">
    <style>
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
            width: 80%;
            margin: auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #ffb9be;
            padding-bottom: 30px;
        }

        h2 {
            color: #d6c9cb;
        }

        .form-container, .table-container {
            background-color: #81656570;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-container {
            border: 2px solid #6f0f15;
            padding: 30px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #6f0f15;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background-color: #ffb9be;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #ffffff;
        }

        input, textarea {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #6f0f15;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ffb9be;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dddddd26;
            text-align: left;
        }

        th {
            background-color: #6f0f15;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .edit-btn, .delete-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            margin: 0 5px;
        }

        .edit-btn {
            background-color: #28a745; /* Green */
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545; /* Red */
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="staffDashboard.php" class="back-button">Back to Dashboard</a>
        <h1>Automated Reminders</h1>
        
        <div class="form-container">
            <h2>Set Up Reminder</h2>
            <form id="reminder-form">
                <label for="class-name">Class/Session Name:</label>
                <input type="text" id="class-name" name="class-name" required>
                
                <label for="reminder-date">Reminder Date and Time:</label>
                <input type="datetime-local" id="reminder-date" name="reminder-date" required>
                
                <label for="message">Reminder Message:</label>
                <textarea id="message" name="message" rows="3" required></textarea>
                
                <button type="submit">Set Reminder</button>
            </form>
        </div>
        
        <div class="table-container">
            <h2>Scheduled Reminders</h2>
            <table id="reminder-table">
                <thead>
                    <tr>
                        <th>Class/Session Name</th>
                        <th>Reminder Date and Time</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Records will be added here dynamically -->
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        document.getElementById('reminder-form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Get form values
            const className = document.getElementById('class-name').value;
            const reminderDate = document.getElementById('reminder-date').value;
            const message = document.getElementById('message').value;
            
            // Create a new table row
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${className}</td>
                <td>${reminderDate}</td>
                <td>${message}</td>
                <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </td>
            `;
            
            // Add the new row to the table
            document.querySelector('#reminder-table tbody').appendChild(newRow);
            
            // Clear form fields
            document.getElementById('reminder-form').reset();
        });

        // Event delegation for Edit and Delete buttons
        document.querySelector('#reminder-table').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-btn')) {
                event.target.parentElement.parentElement.remove();
            }
            
            if (event.target.classList.contains('edit-btn')) {
                const row = event.target.parentElement.parentElement;
                const cells = row.getElementsByTagName('td');
                
                document.getElementById('class-name').value = cells[0].innerText;
                document.getElementById('reminder-date').value = cells[1].innerText;
                document.getElementById('message').value = cells[2].innerText;
                
                row.remove();
            }
        });
    </script>
</body>
</html>
