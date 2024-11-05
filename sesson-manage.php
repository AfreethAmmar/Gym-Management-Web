<?php
include 'connection.php'; // Include your database connection

// SQL query to fetch data from the sessonbookings table
$sql = "SELECT id, name, class_type, date, time FROM sessonbookings";
$result = $conn->query($sql);

$bookings = [];

if ($result->num_rows > 0) {
    // Fetch each row as an associative array
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    /* Basic styling for the dashboard container */
    .admin__container {
      padding: 20px;
      background-color: #f9f9f9;
      border-radius: 8px;
    }

    /* Header styling */
    .section__header {
      font-size: 24px;
      margin-bottom: 20px;
    }

    /* Table styling */
    .admin__table {
      width: 100%;
      border-collapse: collapse;
    }

    .admin__table th, .admin__table td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }

    .admin__table th {
      background-color: #4CAF50;
      color: white;
    }

    .admin__table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .admin__table tr:hover {
      background-color: #ddd;
    }
  </style>
</head>
<body>
  <section class="admin__container" id="admin-bookings">
    <h2 class="section__header">Booking Details</h2>
    <table class="admin__table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Class Type</th>
          <th>Date</th>
          <th>Time</th>
        </tr>
      </thead>
      <tbody id="bookingTableBody">
        <!-- Booking rows will be injected here by JavaScript -->
      </tbody>
    </table>
  </section>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      fetchBookings(); // Call function to fetch and display bookings

      function fetchBookings() {
        fetch('sesson-manage.php') // Fetch data from the PHP script
          .then(response => response.json()) // Parse the JSON response
          .then(data => {
            const tableBody = document.getElementById('bookingTableBody');
            tableBody.innerHTML = ''; // Clear the table body

            data.forEach(booking => {
              const row = document.createElement('tr');
              row.innerHTML = `
                <td>${booking.id}</td>
                <td>${booking.name}</td>
                <td>${booking.class_type}</td>
                <td>${booking.date}</td>
                <td>${booking.time}</td>
              `;
              tableBody.appendChild(row); // Add the new row to the table
            });
          })
          .catch(error => console.error('Error fetching bookings:', error)); // Error handling
      }
    });
  </script>
</body>
</html>
