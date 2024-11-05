<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gymtrack";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle Income Insertion
    if (isset($_POST['incomeDate']) && isset($_POST['incomeType']) && isset($_POST['incomeAmount'])) {
        $date = $_POST['incomeDate'];
        $type = $_POST['incomeType'];
        $amount = $_POST['incomeAmount'];

        $stmt = $conn->prepare("INSERT INTO income (date, type, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $date, $type, $amount);
        $stmt->execute();
        $stmt->close();
    }

    // Handle Expense Insertion
    if (isset($_POST['expenseDate']) && isset($_POST['expenseType']) && isset($_POST['expenseAmount'])) {
        $date = $_POST['expenseDate'];
        $type = $_POST['expenseType'];
        $amount = $_POST['expenseAmount'];

        $stmt = $conn->prepare("INSERT INTO expense (date, type, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $date, $type, $amount);
        $stmt->execute();
        $stmt->close();
    }

    // Handle Deletion
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $table = $_POST['table'];
        $id = $_POST['id'];

        // Validate table name to prevent SQL injection
        if ($table === 'income' || $table === 'expense') {
            $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }

        // Redirect back to the main page
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle Editing
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $table = $_POST['table'];
        $id = $_POST['id'];
        $date = $_POST['editDate'];
        $type = $_POST['editType'];
        $amount = $_POST['editAmount'];

        // Validate table name to prevent SQL injection
        if ($table === 'income' || $table === 'expense') {
            $stmt = $conn->prepare("UPDATE $table SET date = ?, type = ?, amount = ? WHERE id = ?");
            $stmt->bind_param("ssdi", $date, $type, $amount, $id);
            $stmt->execute();
            $stmt->close();
        }

        // Redirect back to the main page
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch monthly report data
$monthlyIncomeQuery = "SELECT id, type, SUM(amount) AS total FROM income WHERE MONTH(date) = MONTH(CURRENT_DATE()) GROUP BY type";
$monthlyExpenseQuery = "SELECT id, type, SUM(amount) AS total FROM expense WHERE MONTH(date) = MONTH(CURRENT_DATE()) GROUP BY type";

$incomeResult = $conn->query($monthlyIncomeQuery);
$expenseResult = $conn->query($monthlyExpenseQuery);

$totalIncome = 0;
$totalExpense = 0;

$incomeData = [];
$expenseData = [];

while ($row = $incomeResult->fetch_assoc()) {
    $incomeData[] = $row;
    $totalIncome += $row['total'];
}

while ($row = $expenseResult->fetch_assoc()) {
    $expenseData[] = $row;
    $totalExpense += $row['total'];
}

$netIncome = $totalIncome - $totalExpense;

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Report - GymTrack Management</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e2f;
            color: #f4f4f9;
            margin: 0;
            padding: 0;
            background-image: url(images/back5.jpg);
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            padding-top: 50px;
            padding-bottom: 50px;
            background-color: rgba(0, 0, 0, 0.7); /* Slight transparency */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .buttons {
            text-align: center;
            margin-bottom: 30px;
        }

        .buttons button {
            background-color: #58000e;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .buttons button:hover {
            background-color: #210307;
        }

        .form-section, .report {
            background-color: #47151d;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h3 {
            margin-bottom: 20px;
            font-size: 22px;
        }

        label {
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
        }

        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
            background-color: #f8f9fa;
            color: #333;
        }

        button[type="submit"],
        .report button.edit-btn,
        .report button.delete-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover,
        .report button.edit-btn:hover,
        .report button.delete-btn:hover {
            background-color: #218838;
        }

        .report button.delete-btn {
            background-color: #dc3545;
        }

        .report button.delete-btn:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #d1415833;
            color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #495057;
        }

        th {
            background-color: #210307;
        }

        tr:nth-child(even) {
            background-color: #58000e;
        }

        tr:hover {
            background-color: #495057;
        }

        thead {
            background-color: #210307;
        }

        .totals h3 {
            margin: 10px 0;
            font-size: 20px;
        }

        /* Modal Styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #47151d;
            margin: 10% auto; /* 10% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            color: #f4f4f9;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .modal-content {
                width: 95%;
            }

            table th, table td {
                padding: 8px;
            }
        }
    </style>
    <script>
        // Function to show specific form sections
        function showForm(formId) {
            document.getElementById('incomeForm').style.display = 'none';
            document.getElementById('expenseForm').style.display = 'none';
            document.getElementById('monthlyReport').style.display = 'none';
            document.getElementById(formId).style.display = 'block';
        }

        // Function to open the edit modal with pre-filled data
        function openEditModal(table, id, date, type, amount) {
            document.getElementById('editTable').value = table;
            document.getElementById('editId').value = id;
            document.getElementById('editDate').value = date;
            document.getElementById('editType').value = type;
            document.getElementById('editAmount').value = amount;

            document.getElementById('editModal').style.display = 'block';
        }

        // Function to close the edit modal
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="buttons">
            <button onclick="showForm('incomeForm')">Daily Income</button>
            <button onclick="showForm('expenseForm')">Daily Expenses</button>
            <button onclick="showForm('monthlyReport')">Monthly Report</button>
            <button><a href="admin.php" style="text-decoration: none; color:white;">back</a></button>
        </div>

        <!-- Income Form -->
        <div id="incomeForm" class="form-section" style="display:none;">
            <h3>Daily Income</h3>
            <form method="POST" action="">
                <label for="incomeDate">Date:</label>
                <input type="date" id="incomeDate" name="incomeDate" required>

                <label for="incomeType">Type of Income:</label>
                <select id="incomeType" name="incomeType" required>
                    <option value="membership">Membership Plan</option>
                    <option value="clothing">Clothing Sales</option>
                    <option value="nutrition">Nutritional Item Sales</option>
                    <option value="equipment">Equipment Sales</option>
                </select>

                <label for="incomeAmount">Amount:</label>
                <input type="number" id="incomeAmount" name="incomeAmount" step="0.01" required>

                <button type="submit">Submit</button>
            </form>
        </div>

        <!-- Expense Form -->
        <div id="expenseForm" class="form-section" style="display:none;">
            <h3>Daily Expenses</h3>
            <form method="POST" action="">
                <label for="expenseDate">Date:</label>
                <input type="date" id="expenseDate" name="expenseDate" required>

                <label for="expenseType">Type of Expense:</label>
                <select id="expenseType" name="expenseType" required>
                    <option value="electricity">Electricity Bill</option>
                    <option value="water">Water Bill</option>
                    <option value="trainer">Trainer Salary</option>
                    <option value="maintenance">Equipment Maintenance</option>
                </select>

                <label for="expenseAmount">Amount:</label>
                <input type="number" id="expenseAmount" name="expenseAmount" step="0.01" required>

                <button type="submit">Submit</button>
            </form>
        </div>

        <!-- Monthly Report -->
        <div id="monthlyReport" class="report" style="display:none;">
            <h2>Monthly Report</h2>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Actions</th> <!-- New column for actions -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3"><strong>Income</strong></td>
                    </tr>
                    <?php foreach ($incomeData as $income) { ?>
                    <tr>
                        <td><?php echo ucfirst($income['type']); ?></td>
                        <td><?php echo '$' . number_format($income['total'], 2); ?></td>
                        <td>
                            <button class="edit-btn" onclick="openEditModal('income', <?php echo $income['id']; ?>, '<?php echo $income['type']; ?>', '<?php echo $income['type']; ?>', <?php echo $income['total']; ?>)">Edit</button>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="table" value="income">
                                <input type="hidden" name="id" value="<?php echo $income['id']; ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this income entry?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="3"><strong>Expenses</strong></td>
                    </tr>
                    <?php foreach ($expenseData as $expense) { ?>
                    <tr>
                        <td><?php echo ucfirst($expense['type']); ?></td>
                        <td><?php echo '$' . number_format($expense['total'], 2); ?></td>
                        <td>
                            <button class="edit-btn" onclick="openEditModal('expense', <?php echo $expense['id']; ?>, '<?php echo $expense['type']; ?>', '<?php echo $expense['type']; ?>', <?php echo $expense['total']; ?>)">Edit</button>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="table" value="expense">
                                <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">
                                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this expense entry?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="totals">
                <h3>Total Income: $<?php echo number_format($totalIncome, 2); ?></h3>
                <h3>Total Expenses: $<?php echo number_format($totalExpense, 2); ?></h3>
                <h3>Net Income: $<?php echo number_format($netIncome, 2); ?></h3>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Record</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="table" id="editTable" value="">
                <input type="hidden" name="id" id="editId" value="">

                <label for="editDate">Date:</label>
                <input type="date" id="editDate" name="editDate" required>

                <label for="editType">Type:</label>
                <select id="editType" name="editType" required>
                    <!-- Options will be dynamically populated based on table type -->
                    <option value="">Select Type</option>
                    <!-- JavaScript will populate appropriate options -->
                </select>

                <label for="editAmount">Amount:</label>
                <input type="number" id="editAmount" name="editAmount" step="0.01" required>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <script>
        // Function to open the edit modal with pre-filled data
        function openEditModal(table, id, type, displayType, amount) {
            document.getElementById('editTable').value = table;
            document.getElementById('editId').value = id;
            document.getElementById('editDate').value = getDateFromType(table, type); // Function to get the date based on type

            // Populate the type dropdown based on table
            const editTypeSelect = document.getElementById('editType');
            editTypeSelect.innerHTML = ''; // Clear existing options

            let options = '';
            if (table === 'income') {
                options += '<option value="membership">Membership Plan</option>';
                options += '<option value="clothing">Clothing Sales</option>';
                options += '<option value="nutrition">Nutritional Item Sales</option>';
                options += '<option value="equipment">Equipment Sales</option>';
            } else if (table === 'expense') {
                options += '<option value="electricity">Electricity Bill</option>';
                options += '<option value="water">Water Bill</option>';
                options += '<option value="trainer">Trainer Salary</option>';
                options += '<option value="maintenance">Equipment Maintenance</option>';
            }

            editTypeSelect.innerHTML = options;
            editTypeSelect.value = type;

            document.getElementById('editAmount').value = amount;

            // Show the modal
            document.getElementById('editModal').style.display = 'block';
        }

        // Function to get date based on table and type (requires additional implementation)
        function getDateFromType(table, type) {
            // This function should fetch the date based on table and type.
            // For simplicity, we'll leave it empty.
            // Alternatively, you can pass the date as a parameter when calling openEditModal.
            return '';
        }
    </script>
</body>
</html>
