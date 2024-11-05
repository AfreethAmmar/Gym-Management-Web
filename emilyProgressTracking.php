<?php    include '../connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracking</title>
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
            padding-bottom: 20px;
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
            margin-bottom: 20px;
            text-align: center;
        }

        .button:hover {
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
            background-color: #28a745;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="emilyStaffDashbord.php" class="button">Back to Dashboard</a>
        <h1>Progress Tracking</h1>
        
        <div class="form-container">
            <h2>Log Workout</h2>
            <form id="workout-form">
                <label for="member-id">Member ID:</label>
                <input type="text" id="member-id" name="member-id" required>
                
                <label for="workout-date">Date:</label>
                <input type="date" id="workout-date" name="workout-date" required>
                
                <label for="workout-type">Workout Type:</label>
                <input type="text" id="workout-type" name="workout-type" required>
                
                <label for="duration">Duration (minutes):</label>
                <input type="number" id="duration" name="duration" required>
                
                <label for="notes">Notes:</label>
                <textarea id="notes" name="notes" rows="3"></textarea>
                
                <button type="submit">Log Workout</button>
            </form>
        </div>
        
        <div class="form-container">
            <h2>Set Fitness Goals</h2>
            <form id="goal-form">
                <label for="goal">Goal:</label>
                <input type="text" id="goal" name="goal" required>
                
                <label for="target-date">Target Date:</label>
                <input type="date" id="target-date" name="target-date" required>
                
                <button type="submit">Set Goal</button>
            </form>
        </div>
        
        <div class="table-container">
            <h2>Workout Records</h2>
            <table id="workout-table">
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Date</th>
                        <th>Workout Type</th>
                        <th>Duration (minutes)</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Workout records will be added here dynamically -->
                </tbody>
            </table>
        </div>
        
        <div class="table-container">
            <h2>Fitness Goals</h2>
            <table id="goal-table">
                <thead>
                    <tr>
                        <th>Goal</th>
                        <th>Target Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fitness goals will be added here dynamically -->
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        // Handle workout logging
        document.getElementById('workout-form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Get form values
            const memberId = document.getElementById('member-id').value;
            const workoutDate = document.getElementById('workout-date').value;
            const workoutType = document.getElementById('workout-type').value;
            const duration = document.getElementById('duration').value;
            const notes = document.getElementById('notes').value || 'N/A';
            
            // Create a new table row for workouts
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${memberId}</td>
                <td>${workoutDate}</td>
                <td>${workoutType}</td>
                <td>${duration}</td>
                <td>${notes}</td>
                <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </td>
            `;
            
            // Add the new row to the workout table
            document.querySelector('#workout-table tbody').appendChild(newRow);
            
            // Clear form fields
            document.getElementById('workout-form').reset();
        });

        // Handle goal setting
        document.getElementById('goal-form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Get form values
            const goal = document.getElementById('goal').value;
            const targetDate = document.getElementById('target-date').value;
            
            // Create a new table row for goals
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${goal}</td>
                <td>${targetDate}</td>
                <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </td>
            `;
            
            // Add the new row to the goals table
            document.querySelector('#goal-table tbody').appendChild(newRow);
            
            // Clear form fields
            document.getElementById('goal-form').reset();
        });

        // Event delegation for Edit and Delete buttons
        document.querySelector('#workout-table').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-btn')) {
                event.target.parentElement.parentElement.remove();
            }
            
            if (event.target.classList.contains('edit-btn')) {
                const row = event.target.parentElement.parentElement;
                const cells = row.getElementsByTagName('td');
                
                document.getElementById('member-id').value = cells[0].innerText;
                document.getElementById('workout-date').value = cells[1].innerText;
                document.getElementById('workout-type').value = cells[2].innerText;
                document.getElementById('duration').value = cells[3].innerText;
                document.getElementById('notes').value = cells[4].innerText === 'N/A' ? '' : cells[4].innerText;
                
                row.remove();
            }
        });

        document.querySelector('#goal-table').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-btn')) {
                event.target.parentElement.parentElement.remove();
            }
            
            if (event.target.classList.contains('edit-btn')) {
                const row = event.target.parentElement.parentElement;
                const cells = row.getElementsByTagName('td');
                
                document.getElementById('goal').value = cells[0].innerText;
                document.getElementById('target-date').value = cells[1].innerText;
                
                row.remove();
            }
        });
    </script>
</body>
</html>
