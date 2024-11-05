<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $product_name = $_POST['product_name'];
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $product_price = $_POST['product_price'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE orders SET name=?, address=?, phone=?, product_name=?, size=?, quantity=?, product_price=? WHERE id=?");
    $stmt->bind_param("ssssdidi", $name, $address, $phone, $product_name, $size, $quantity, $product_price, $id);

    if ($stmt->execute()) {
        echo "Order updated successfully.";
    } else {
        echo "Error updating order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the orders page
    header("Location: onlineOrders.php");
    exit();
}

// Fetch orders from the database
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);

if ($result === false) {
    echo "Error: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: #333;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        button {
            padding: 8px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .btn {
            color: white;
            font-weight: bold;
        }

        .edit-btn {
            background-color: #2196F3;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .edit-btn:hover {
            background-color: #0b7dda;
        }

        .delete-btn:hover {
            background-color: #da190b;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
            padding-top: 100px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 30px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .modal-content h2 {
            color: #333;
            text-align: center;
        }

        .modal-content label {
            font-weight: bold;
            color: #555;
        }

        .modal-content input {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .modal-content .btn {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            font-size: 16px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover, .close:focus {
            color: black;
            cursor: pointer;
        }

        .back-btn a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Orders</h1>
        <div class="back-btn">
            <a href="admin.php">Back</a>
        </div>
        <table id="ordersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Product Name</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Product Price</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . ($row['size'] !== null ? number_format($row['size'], 2) : '-') . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . number_format($row['product_price'], 2) . " LKR</td>";
                        echo "<td>" . number_format($row['total_price'], 2) . " LKR</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>
                                <button type='button' class='btn edit-btn' onclick='openModal(" . $row['id'] . ", \"" . $row['name'] . "\", \"" . $row['address'] . "\", \"" . $row['phone'] . "\", \"" . $row['product_name'] . "\", " . $row['size'] . ", " . $row['quantity'] . ", " . $row['product_price'] . ")'>Edit</button>
                                <form action='deleteOrder.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                                    <button type='submit' class='btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this order?\");'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Edit Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Edit Order</h2>
                <form action="onlineOrders.php" method="POST">
                    <input type="hidden" id="orderId" name="id">
                    <label for="name">Name:</label>
                    <input type="text" id="editName" name="name" required>
                    <label for="address">Address:</label>
                    <input type="text" id="editAddress" name="address" required>
                    <label for="phone">Phone:</label>
                    <input type="text" id="editPhone" name="phone" required>
                    <label for="product_name">Product Name:</label>
                    <input type="text" id="editProductName" name="product_name" required>
                    <label for="size">Size:</label>
                    <input type="number" id="editSize" name="size" required>
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="editQuantity" name="quantity" required>
                    <label for="product_price">Product Price:</label>
                    <input type="number" id="editProductPrice" name="product_price" required>
                    <button type="submit" class="btn edit-btn">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id, name, address, phone, product_name, size, quantity, product_price) {
            document.getElementById("editModal").style.display = "block";
            document.getElementById("orderId").value = id;
            document.getElementById("editName").value = name;
            document.getElementById("editAddress").value = address;
            document.getElementById("editPhone").value = phone;
            document.getElementById("editProductName").value = product_name;
            document.getElementById("editSize").value = size;
            document.getElementById("editQuantity").value = quantity;
            document.getElementById("editProductPrice").value = product_price;
        }

        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }
    </script>
</body>
</html>
