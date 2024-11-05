<?php
// Include database connection
include('connection.php');

// Function to upload image and return the filename
function uploadImage($fileInput) {
    if (isset($fileInput) && $fileInput['error'] == 0) {
        $targetDir = "images/";
        $fileName = basename($fileInput['name']);
        $targetFilePath = $targetDir . $fileName;

        // Check if file is an actual image
        $check = getimagesize($fileInput['tmp_name']);
        if ($check !== false) {
            // Move the file to the desired folder
            if (move_uploaded_file($fileInput['tmp_name'], $targetFilePath)) {
                return $fileName;
            }
        }
    }
    return null;
}

// Handle adding a new plan
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $planDescription = $_POST['planDescription'];
    $image = uploadImage($_FILES['image']);

    $query = "INSERT INTO gym_plans (name, price, planDescription, image) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdss", $name, $price, $planDescription, $image);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "New plan added successfully!";
    } else {
        echo "Error adding new plan.";
    }
}

// Handle updating an existing plan
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $planDescription = $_POST['planDescription'];
    $image = uploadImage($_FILES['image']);

    if ($image) {
        // If new image is uploaded, update image too
        $query = "UPDATE gym_plans SET name=?, price=?, planDescription=?, image=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sdssi", $name, $price, $planDescription, $image, $id);
    } else {
        // Update without changing image
        $query = "UPDATE gym_plans SET name=?, price=?, planDescription=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sdsi", $name, $price, $planDescription, $id);
    }

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Plan updated successfully!";
    } else {
        echo "Error updating plan.";
    }
}

// Handle deleting a plan
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Delete the plan from the database
    $query = "DELETE FROM gym_plans WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Plan deleted successfully!";
    } else {
        echo "Error deleting plan.";
    }
}

// Fetch all plans from the database
$query = "SELECT * FROM gym_plans";
$result = $conn->query($query);
$menuItems = $result->fetch_all(MYSQLI_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu Management - The Gallery Café</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS styles here (include the CSS block from your example) */
        /* General Styles */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    background: #f4f4f9;
    color: #333;
    background-image:
            url(images/back5.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            
        
}

header {
    background: #1f1f1f73;
    color: #fff;
    padding: 15px;
    text-align: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
   
}

header h1 {
    margin: 0;
    font-size: 2rem;
    color: #ffffffa1;

}

main {
    max-width: 1100px;
    margin: 20px auto;
    padding: 40px;
    background: #fff;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    background-color: #380808e6;
}

h2 {
    margin-bottom: 20px;
    font-weight: 500;
    font-size: 1.6rem;
    color: #ffffff;
    text-align: center;
}

.admin-form {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.admin-form label {
    font-size: 0.9rem;
    color: #ffffff;
}

.admin-form input, .admin-form select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 5px;
    border: 1px solid #ddd;
    background-color: #f8f9fa;
    font-size: 0.9rem;
    color: #333;
}

.admin-form button {
    grid-column: span 2;
    background-color:  #ff000094;
    color: #fff;
    padding: 10px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.admin-form button:hover {
    background-color: #7b0e0e;
}

.menu-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.05);
}

.menu-table th, .menu-table td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    color: white;
}

.menu-table th {
    background-color:  #ff000094;
    color: #fff;
    font-weight: 600;
}

.menu-table td img {
    max-width: 60px;
    border-radius: 5px;
}

.menu-table button {
    background-color: #ff5e57;
    color: #fff;
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.menu-table button:hover {
    background-color: #e04a42;
}

.edit-btn button {
    background-color: #1f7ae0;
}

.edit-btn button:hover {
    background-color: #145bb5;
}

/* Popup Styles */
.popup {
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

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
}

.popup-content h2 {
    margin-top: 0;
    font-size: 1.4rem;
}

.popup-content input, .popup-content select {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.popup-content button {
    margin-top: 20px;
    width: 100%;
    background-color: #7b0e0e;
    color: #fff;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.popup-content .close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 1.5rem;
    color: #aaa;
    cursor: pointer;
}

footer {
    background: #1f1f1f;
    color: #fff;
    text-align: center;
    padding: 10px;
    position: absolute;
    bottom: 0;
    width: 100%;
}
nav ul li a {
    color: #ffffffa1;
    text-decoration: none;
    font-size: 1rem;
}

.admin-form textarea{
    width: 550px;
    height: 100px;
}
    </style>
</head>
<body>
    <header>
        <h1>Package Management</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form class="admin-form" method="post" enctype="multipart/form-data">
            <div>
                <label for="plan">Plan</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="price">Price</label>
                <input type="text" id="price" name="price" required>
            </div>
            <div>
            <label for="planDescription">Description:</label><br>
            <textarea id="planDescription" name="planDescription" required></textarea>
            </div>
            <div>
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" name="add">Add Menu Item</button>
        </form>

        <table class="menu-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($menuItems as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?></td>
                    <td><?php echo htmlspecialchars($item['planDescription']); ?></td>
                    <td><img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                    <td>
                        <a href="#" class="edit-btn" 
                           data-id="<?php echo $item['id']; ?>" 
                           data-name="<?php echo htmlspecialchars($item['name']); ?>" 
                           data-price="<?php echo htmlspecialchars($item['price']); ?>" 
                           data-planDescription="<?php echo htmlspecialchars($item['planDescription']); ?>" 
                           data-image="<?php echo htmlspecialchars($item['image']); ?>">
                            <button>Edit</button>
                        </a>
                        <a href="?delete=<?php echo $item['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">
                            <button>Delete</button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Edit Menu Item Popup Form -->
        <div id="editPopup" class="popup">
            <div class="popup-content">
                <span class="close">&times;</span>
                <h2>Edit Menu Item</h2>
                <form id="editForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="editId" name="id">
                    <label for="editName">Menu Item Name:</label>
                    <input type="text" id="editName" name="name" required>

                    <label for="editPrice">Price:</label>
                    <input type="text" id="editPrice" name="price" required>
                      
                    <label for="editplanDescription">Description:</label>
                     <textarea id="editplanDescription" name="planDescription" rows="4" required></textarea>

                    <label for="editImage">Image:</label>
                    <input type="file" id="editImage" name="image" accept="image/*">

                    <button type="submit" name="update">Update</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('editId').value = this.getAttribute('data-id');
                document.getElementById('editName').value = this.getAttribute('data-name');
                document.getElementById('editPrice').value = this.getAttribute('data-price');
                document.getElementById('editplanDescription').value = this.getAttribute('data-planDescription');
                document.getElementById('editPopup').style.display = 'flex';
            });
        });

        document.querySelector('.close').addEventListener('click', function () {
            document.getElementById('editPopup').style.display = 'none';
        });
    </script>
</body>
</html>
