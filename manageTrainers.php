<?php
// Database connection settings
$host = 'localhost'; // or your host
$dbname = 'gymTrack';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted for adding a trainer
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_trainer'])) {
    $name = $_POST['trainer-name'];
    $type = $_POST['trainer-type'];
    $description = $_POST['trainer-description'];

    // Handle file upload
    if (isset($_FILES['trainer-image']) && $_FILES['trainer-image']['error'] == 0) {
        $image = $_FILES['trainer-image']['name'];
        $tmp_image = $_FILES['trainer-image']['tmp_name'];
        $upload_dir = __DIR__ . '/assets/'; // Absolute path to assets directory

        // Ensure the assets directory exists or attempt to create it
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                die("Failed to create directories.");
            }
        }

        $upload_file = $upload_dir . basename($image);

        if (move_uploaded_file($tmp_image, $upload_file)) {
            // File upload successful, now insert data into the database
            try {
                $stmt = $pdo->prepare("INSERT INTO trainers (name, type, image, description) VALUES (:name, :type, :image, :description)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':image', $image);
                $stmt->bindParam(':description', $description);

                if ($stmt->execute()) {
                    echo "Trainer added successfully!";
                } else {
                    echo "Error adding trainer.";
                }
            } catch (PDOException $e) {
                die("Error executing query: " . $e->getMessage());
            }
        } else {
            die("Error uploading file: " . error_get_last()['message']);
        }
    } else {
        die("No file uploaded or there was an upload error: " . $_FILES['trainer-image']['error']);
    }
}

// Check if the delete button is pressed
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM trainers WHERE id = :id");
        $stmt->bindParam(':id', $delete_id);
        if ($stmt->execute()) {
            echo "Trainer deleted successfully!";
        } else {
            echo "Error deleting trainer.";
        }
    } catch (PDOException $e) {
        die("Error executing query: " . $e->getMessage());
    }
}

// Retrieve all trainers from the database
$stmt = $pdo->query("SELECT * FROM trainers");
$trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trainers</title>
    <style>
        /* General Section Styling */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background: #f4f4f9;
            color: #333;
            background-image:  url(images/back5.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            padding-top: 50px;
        }

        .section__container {
            padding: 20px;
            background-color: #380808;
        }

        .section__header {
            font-size: 2em;
            margin-bottom: 15px;
            color: #fff;
        }

        .section__description {
            font-size: 1.2em;
            margin-bottom: 30px;
            color: #555;
        }

        /* Form Container Styling */
        .trainer__form-container {
            max-width: 800px;
            margin: 0 auto;
            background: #380808e6; /* Main form background color */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form__group {
            margin-bottom: 15px;
        }

        .form__group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #fff; /* Label text color */
        }

        .form__group input[type="text"],
        .form__group select,
        .form__group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form__group input[type="file"] {
            padding: 3px;
        }

        .form__group textarea {
            resize: vertical;
        }

        /* Button Styling */
        button {
            background-color: #a91721; /* Button background color */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #a917214d; /* Button hover color */
        }

        header {
            background: #1f1f1f73; /* Header background color */
            color: #fff;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
            color: #ffffffa1; /* Header text color */
        }

        nav ul li a {
            color: #ffffffa1; /* Navigation link color */
            text-decoration: none;
            font-size: 1rem;
        }

        /* Display Trainers Table */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            color: #fff; /* Table text color */
            background-color: #380808e6;
        }

        table th {
            background-color: #a91721; /* Table header background color */
        }

        table img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        h2 {
            text-align: center;
            color: #fff;
            font-size: xx-large;
            font-weight: 1000;
        }
        /* Button Styling for Edit and Delete */
.actions {
    display: flex; /* Align buttons side by side */
    gap: 10px; /* Space between buttons */
}

.actions a {
    background-color: #1f1f1f; /* Dark background color for buttons */
    color: #fff; /* White text color */
    padding: 8px 12px; /* Padding for buttons */
    text-decoration: none; /* Remove underline from links */
    border-radius: 4px; /* Rounded corners */
    transition: background-color 0.3s; /* Smooth background color transition */
}

.actions a:hover {
    background-color: #a91721; /* Change background on hover */
}

    </style>
</head>
<body>
<header>
    <h1>Manage Trainers</h1>
    <nav>
        <ul>
            <li><a href="admin.php">Admin</a></li>
        </ul>
    </nav>
</header>

<section class="section__container trainer__form-container" id="trainer-form">
    <form action="manageTrainers.php" method="POST" enctype="multipart/form-data">
        <div class="form__group">
            <label for="trainer-name">Name:</label>
            <input type="text" id="trainer-name" name="trainer-name" required>
        </div>
        <div class="form__group">
            <label for="trainer-type">Type:</label>
            <select id="trainer-type" name="trainer-type" required>
                <option value="" disabled selected>Select Trainer Type</option>
                <option value="Strength and Conditioning">Strength and Conditioning</option>
                <option value="Flexibility & Mobility">Flexibility & Mobility</option>
                <option value="Weight Loss">Weight Loss</option>
            </select>
        </div>
        <div class="form__group">
            <label for="trainer-image">Image:</label>
            <input type="file" id="trainer-image" name="trainer-image" accept="image/*" required>
        </div>
        <div class="form__group">
            <label for="trainer-description">Description:</label>
            <textarea id="trainer-description" name="trainer-description" rows="4" required></textarea>
        </div>
        <button type="submit" name="add_trainer">Add Trainer</button>
    </form>
</section>

<h2>Trainer List</h2>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Image</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($trainers as $trainer): ?>
        <tr>
            <td><?= htmlspecialchars($trainer['name']) ?></td>
            <td><?= htmlspecialchars($trainer['type']) ?></td>
            <td><img src="assets/<?= htmlspecialchars($trainer['image']) ?>" alt="<?= htmlspecialchars($trainer['name']) ?>"></td>
            <td><?= htmlspecialchars($trainer['description']) ?></td>
            <td>
    <div class="actions">
        <a href="manageTrainers.php?delete_id=<?= $trainer['id'] ?>" onclick="return confirm('Are you sure you want to delete this trainer?');">Delete</a>
        <a href="editTrainer.php?id=<?= $trainer['id'] ?>">Edit</a>
    </div>
</td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
