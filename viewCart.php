<?php
// Include the database connection file
include('connection.php');

// Initialize grand total
$grandTotal = 0;

// Fetch all cart items from the `cart_items` table
$sql = "SELECT * FROM cart_items";
$result = $conn->query($sql);

// Check if form is submitted to remove an item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    // Get the item ID from the form
    $id = $_POST['delete_id'];

    // Delete the item from the `cart_items` table
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the cart view page after successful deletion
        echo "<script>alert('Item removed successfully!'); window.location.href='viewCart.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Check if form is submitted for order placement
// Check if form is submitted for order placement

// Initialize grand total
$grandTotal = 0;

// Fetch all cart items from the `cart_items` table
$sql = "SELECT * FROM cart_items";
$result = $conn->query($sql);

// Check if form is submitted to remove an item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    // Get the item ID from the form
    $id = $_POST['delete_id'];

    // Delete the item from the `cart_items` table
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the cart view page after successful deletion
        echo "<script>alert('Item removed successfully!'); window.location.href='viewCart.php';</script>";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Check if form is submitted for order placement
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    // Get form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Calculate the total price from the cart items
    $cartItems = $conn->query($sql);
    
    if ($cartItems->num_rows > 0) {
        while ($row = $cartItems->fetch_assoc()) {
            $totalPrice = $row['product_price'] * $row['quantity'];
            $grandTotal += $totalPrice;

            // Insert each cart item as an order
            $stmt = $conn->prepare("INSERT INTO orders (name, address, phone, product_name, size, quantity, product_price, total_price, grand_total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                // Bind parameters
                $stmt->bind_param(
                    "ssssiiddd",
                    $name,
                    $address,
                    $phone,
                    $row['product_name'],
                    $row['size'],
                    $row['quantity'],
                    $row['product_price'],
                    $totalPrice,
                    $grandTotal
                );

                // Execute the query
                if ($stmt->execute()) {
                    // Clear the cart after placing the order
                    $conn->query("DELETE FROM cart_items");
                    echo "<script>alert('Order placed successfully!'); window.location.href='index.php.#Shop';</script>";
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                // Error in preparing the statement
                echo "Error preparing the statement: " . $conn->error;
            }
        }
    } else {
        echo "Your cart is empty. Cannot place an order.";
    }
}

// Close the connection after everything is done
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    
    <style>
        /* Cart table styling */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .cart-table th, .cart-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .cart-table th {
            background-color: #f2f2f2;
        }

        .grand-total {
            text-align: right;
            font-weight: bold;
        }

        /* Buttons */
        .delete-btn, .checkout-btn {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }

        .delete-btn:hover, .checkout-btn:hover {
            background-color: #d32f2f;
        }

        .submit-btn {
            text-align: center;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-btn:hover {
            color: black;
        }
    </style>
</head>
<body>

<h2>Your Cart</h2>

<?php
// Display the cart items
if ($result->num_rows > 0) {
    echo '<table class="cart-table">';
    echo '<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Size</th><th>Total Price</th><th>Actions</th></tr>';

    // Loop through the cart items
    while ($row = $result->fetch_assoc()) {
        $totalPrice = $row['product_price'] * $row['quantity'];
        $grandTotal += $totalPrice;
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td><?php echo htmlspecialchars($row['product_price']); ?>/-</td>
            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
            <td><?php echo htmlspecialchars($row['size']); ?></td> <!-- Display size here -->
            <td><?php echo htmlspecialchars($totalPrice); ?>/-</td>
            <td>
                <!-- Delete Item -->
                <form action="viewCart.php" method="POST">
                    <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="delete-btn">Remove</button>
                </form>
            </td>
        </tr>
        <?php
    }

    echo '<tr><td colspan="4" class="grand-total">Grand Total:</td><td colspan="2">' . htmlspecialchars($grandTotal) . '/-</td></tr>';
    echo '</table>';
} else {
    echo "<p>Your cart is empty!</p>";
}
?>

<!-- Proceed to Checkout button -->
<div class="submit-btn">
    <button class="checkout-btn" onclick="openModal()">Buy</button>
    <button class="checkout-btn" onclick="window.location.href='index.php.#Shop'">Back to Shop</button>
</div>

<!-- Modal for Buy Form -->
<div id="buyModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Checkout Form</h2>

        <form action="viewCart.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" name="name" required><br><br>

            <label for="address">Address:</label>
            <input type="text" name="address" required><br><br>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" required><br><br>

            <h3>Your Order Summary:</h3>
            <ul>
                <?php
                // Display cart details inside the modal
                $result->data_seek(0); // Reset result pointer to the start
                while ($row = $result->fetch_assoc()) {
                    $totalPrice = $row['product_price'] * $row['quantity'];
                    echo "<li>Product: " . htmlspecialchars($row['product_name']) . " - Size: " . htmlspecialchars($row['size']) . " - Quantity: " . htmlspecialchars($row['quantity']) . " - Total Price: " . htmlspecialchars($totalPrice) . "/-</li>";
                }
                ?>
            </ul>

            <p><strong>Grand Total: </strong><?php echo htmlspecialchars($grandTotal); ?>/-</p>

            <button type="submit" name="place_order" class="checkout-btn">Confirm Order</button>
        </form>
    </div>
</div>

<script>
    // Function to open the modal
    function openModal() {
        document.getElementById('buyModal').style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('buyModal').style.display = 'none';
    }
</script>

</body>
</html>
