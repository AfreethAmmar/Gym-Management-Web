<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gymtrack";  // Correct the database name here

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'clothing';

// Query to fetch items from menu_items table based on the selected category
$sql = "SELECT name, price, image, category FROM menu_items WHERE category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $selectedCategory); // Bind the selected category to the query
$stmt->execute();
$result = $stmt->get_result();

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
    />
    <link rel="stylesheet" href="styles.css" />
    <title>Web Design Mastery | Power</title>
    <style>
            /* Ensure all images are displayed with the same size */
            .product-image {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 8px;
      }

      /* Additional styling for category buttons */
      .category-filter {
          text-align: center;
          margin-bottom: 20px;
      }

      .category-btn {
          padding: 10px 20px;
          margin: 0 10px;
          background-color: #89131b;
          color: white;
          text-decoration: none;
          border-radius: 5px;
      }

      .category-btn:hover {
          background-color: #89131b;
      }





   /* Basic styling for demonstration */
   body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .section__container {
            padding: 20px;
        }
        .section__header {
            font-size: 24px;
            padding: 30px;
        }
        .section__description {
            margin-bottom: 20px;
        }
        .trainer__grid {
            flex-wrap: wrap;
            gap: 20px;
        }
        .trainer__card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: 300px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }
        .trainer__card img {
            width: 100%;
            height: auto;
        }
        .trainer__content {
            text-align: center;
        }
        .trainer__content h4 {
            margin: 10px 0 5px;
        }
        .trainer__content h5 {
            color: #666;
            margin: 0;
        }
        .trainer__content p {
            margin: 10px 0;
        }
        .trainer__content hr {
            margin: 10px 0;
        }
        .trainer__socials a {
            margin: 0 5px;
            color: #333;
            text-decoration: none;
        }
        .trainer__socials i {
            font-size: 18px;
        }
        .book-btn {
  padding: 5px 10px;
  font-size: large;
  font-weight: 800;
  background-color: #89131b;
  color: white;
}




.popup-form {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8); /* Darker background */
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  transition: all 0.3s ease-in-out; /* Smooth appearance */
}

.popup-content {
  background-color: #f9f9f9; /* Light background */
  padding: 40px;
  border-radius: 15px; /* Rounded corners */
  width: 450px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); /* Soft shadow */
  position: relative;
  text-align: left;
  transition: transform 0.3s ease-in-out; /* Smooth scaling */
  transform: scale(0.9); /* Initial small size for animation */
}

.popup-form.show .popup-content {
  transform: scale(1); /* Full size when active */
}

.close-btn {
  position: absolute;
  right: 15px;
  top: 15px;
  font-size: 24px;
  color: #333;
  cursor: pointer;
  transition: color 0.2s ease-in-out;
}

.close-btn:hover {
  color: #ff0000; /* Red color on hover */
}

h3 {
  margin-bottom: 20px;
  font-size: 24px;
  color: #333;
  font-weight: bold;
  text-align: center;
}

label {
  font-size: 14px;
  color: #555;
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="tel"],
select {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #fff;
  font-size: 16px;
  color: #333;
  outline: none;
  transition: border-color 0.3s ease-in-out;
}

input[type="text"]:focus,
input[type="tel"]:focus,
select:focus {
  border-color: #007BFF; /* Focused border color */
}

button.submit-btn {
  width: 100%;
  padding: 15px;
  background-color: #89131b; /* Green color for confirm button */
  color: #fff;
  font-size: 18px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

button.submit-btn:hover {
  background-color: #3f070a; /* Darker green on hover */
}

/* Animation for form appearance */
.popup-form.show {
  opacity: 1;
  transition: opacity 0.3s ease-in-out;
}



/* Add to Cart Button Styles */
.online-btn {
  background-color: #ff00006e; /* Primary blue color */
  color: #fff; /* White text */
  padding: 10px 20px; /* Button padding */
  border: none; /* No border */
  border-radius: 5px; /* Rounded corners */
  cursor: pointer; /* Cursor change on hover */
  font-size: 16px; /* Font size */
  font-weight: bold; /* Bold text */
  transition: background-color 0.3s ease, transform 0.3s ease; /* Smooth transition */
}

.online-btn:hover {
  background-color: #89131b; /* Darker blue on hover */
  transform: scale(1.05); /* Slightly enlarge on hover */
}

/* Add to Cart Button Focus (when clicked) */
.online-btn:focus {
  outline: none; /* Remove outline */
  background-color: #004085; /* Even darker blue on click */
  transform: scale(1.1); /* More scale effect */
}

/* Disable Add to Cart Button (if item is out of stock or not available) */
.online-btn:disabled {
  background-color: #ccc; /* Gray background */
  cursor: not-allowed; /* Disabled cursor */
  transform: none; /* No scale effect */
  color: #666; /* Dimmed text color */
}

/* Mobile Responsiveness for Add to Cart Button */
@media screen and (max-width: 768px) {
  .online-btn {
    width: 100%; /* Full width on smaller screens */
    padding: 15px; /* Larger padding */
  }
}


/* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed;
    z-index: 1000; /* Ensure modal is on top */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.7); /* Dark background with transparency */
    justify-content: center; /* Center content horizontally */
    align-items: center; /* Center content vertically */
}

/* Modal content styling */
.modal-content {
    background-color: #ffffff; /* White background for the modal */
    margin: 20px auto; /* Margin around the modal */
    padding: 20px; /* Padding inside the modal */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Soft shadow */
    width: 90%; /* Full width with margin */
    max-width: 400px; /* Maximum width for the modal */
    animation: fadeIn 0.3s; /* Fade-in animation */
}

/* Close button styling */
.close {
    color: #aaa; /* Light gray color */
    float: right; /* Align to the right */
    font-size: 24px; /* Font size */
    font-weight: bold; /* Bold font weight */
}

.close:hover,
.close:focus {
    color: #000; /* Darker color on hover */
    text-decoration: none; /* No underline */
    cursor: pointer; /* Pointer cursor on hover */
}

/* Heading style */
h2 {
    margin-top: 0; /* Remove top margin */
    color: #333; /* Dark text color for headings */
}

/* Paragraph styling */
p {
    color: #fff; /* Slightly lighter text color */
    font-size: 18px; /* Font size */
    margin: 10px 0; /* Margin for spacing */
}

/* Continue button styling */
button {
    background-color: #007BFF; /* Bootstrap primary color */
    color: white; /* White text */
    padding: 10px 15px; /* Padding for button */
    border: none; /* No border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor */
    font-size: 16px; /* Font size */
    transition: background-color 0.3s; /* Smooth transition for hover */
    margin-top: 15px; /* Margin for spacing */
}

button:hover {
    background-color: #89131bdb; /* Darker shade on hover */
}

/* Animation for modal */
@keyframes fadeIn {
    from {
        opacity: 0; /* Start fully transparent */
    }
    to {
        opacity: 1; /* End fully opaque */
    }
}



.cart-icon {
  position: relative; /* Position relative for absolute child elements */
}

.cart-icon a {
  display: inline-block; /* Allows padding and hover effects */
  font-size: 24px; /* Size of the shopping cart icon */
  color: #6f0f15; /* Default color of the icon */
  transition: transform 0.3s ease, color 0.3s ease; /* Animation for transform and color */
}

.cart-icon a:hover {
  transform: scale(1.1); /* Scale the icon slightly on hover */
  color: #ffb9be; /* Change color on hover */
}

.cart-icon i {
  position: relative; /* Positioning for the badge */
}

/* Optional: Badge for showing item count */
.cart-icon .badge {
  position: absolute;
  top: -10px; /* Adjust position above the icon */
  right: -10px; /* Adjust position to the right */
  background-color: #ff4d4d; /* Badge background color */
  color: white; /* Badge text color */
  border-radius: 50%; /* Round badge */
  padding: 5px 10px; /* Padding for badge */
  font-size: 14px; /* Font size for badge */
  display: flex; /* Center the text */
  justify-content: center; /* Center the text */
  align-items: center; /* Center the text */
}

    </style>
  </head>
  <body>
  <header class="header">
  <nav class="navbar" id="navbar">
    <div class="nav__header">
      <div class="nav__logo">
        <a href="#"><img src="images/4jf16gol.png" alt="logo" height="100px" width="200px" />GymTrack</a>
      </div>
      <div class="nav__menu__btn" id="menu-btn">
        <span><i class="ri-menu-line"></i></span>
      </div>
    </div>
    <ul class="nav__links" id="nav-links">
      <li class="link"><a href="#home">Home</a></li>
      <li class="link"><a href="#about">About</a></li>
      <li class="link"><a href="#class">Classes</a></li>
      <li class="link"><a href="#trainer">Trainers</a></li>
      <li class="link"><a href="#price">Pricing</a></li>
      <li class="link"><a href="#Shop">Shop</a></li>
      <li class="link"><a href="">Membership Plan</a></li>
      <li class="link"><button class="btn">Contact Us</button></li>
      <li class="link"><button class="btn"><a href="customerLogout.php">LogOut</a></button></li>
    </ul>
    <!-- Cart Icon -->
    
  </nav>

  <div class="section__container header__container" id="home">
    <div class="header__image">
      <img src="assets/header.png" alt="header" />
    </div>
    <div class="header__content">
      <h4>Welcome To</h4>
      <h1 class="section__header">Gym Track!</h1>
      <p>
        Unleash your potential and embark on a journey towards a stronger,
        fitter, and more confident you. Sign up for 'Make Your Body Shape'
        now and witness the incredible transformation your body is capable
        of!
      </p>
    </div>
  </div>
</header>

    <section class="section__container about__container" id="about">
      <div class="about__image">
        <img class="about__bg" src="assets/dot-bg.png" alt="bg" />
        <img src="assets/about.png" alt="about" />
      </div>
      <div class="about__content">
        <h2 class="section__header">Our Story</h2>
        <p class="section__description">
          Led by our team of expert and motivational instructors, "The Class You
          Will Get Here" is a high-energy, results-driven session that combines
          a perfect blend of cardio, strength training, and functional
          exercises.
        </p>
        <div class="about__grid">
          <div class="about__card">
            <span><i class="ri-open-arm-line"></i></span>
            <div>
              <h4>Open Door Policy</h4>
              <p>
                We believe in providing unrestricted access to all individuals,
                regardless of their fitness level, age, or background.
              </p>
            </div>
          </div>
          <div class="about__card">
            <span><i class="ri-shield-cross-line"></i></span>
            <div>
              <h4>Fully Insured</h4>
              <p>
                Your peace of mind is our top priority, and our commitment to
                your safety extends to every aspect of your fitness journey.
              </p>
            </div>
          </div>
          <div class="about__card">
            <span><i class="ri-p2p-line"></i></span>
            <div>
              <h4>Personal Trainer</h4>
              <p>
                With personalized workout plans tailored to your needs, we will
                ensure that you get the most out of your gym experience.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section__container class__container" id="class">
      <h2 class="section__header">Our Classes</h2>
      <p class="section__description">
        Discover a diverse range of exhilarating classes at our gym designed to
        cater to all fitness levels and interests. Whether you're a seasoned
        athlete or just starting your fitness journey, our classes offer
        something for everyone.
      </p>
      <div class="class__grid">
        <div class="class__card">
          <img src="assets/dot-bg.png" alt="bg" class="class__bg" />
          <img src="assets/class-1.jpg" alt="class" />
          <div class="class__content">
            <h4>Strength Training</h4>
            <p>Resistance Training</p>
          </div>
        </div>
        <div class="class__card">
          <img src="assets/dot-bg.png" alt="bg" class="class__bg" />
          <img src="images/yoga.webp" height="230px" alt="class" />
          <div class="class__content">
            <h4>Flexibility & Mobility</h4>
            <p>Yoga & Pilates</p>
          </div>
        </div>
        <div class="class__card">
          <img src="assets/dot-bg.png" alt="bg" class="class__bg" />
          <img src="images/weight-loss-7705107_1280.webp" height="230px" alt="class" />
          <div class="class__content">
            <h4>Weight Loss</h4>
            <p>Weight Loss Training</p>
          </div>
        </div>
        <div class="class__card">
          <img src="assets/dot-bg.png" alt="bg" class="class__bg" />
          <img src="assets/class-4.jpg" alt="class" />
          <div class="class__content">
            <h4>Group Fitness</h4>
            <p>Zumba or Dance</p>
          </div>
        </div>
      </div>
      <div class="book">
            <button class="book-btn" ><a style="color:white;" href="bmi.php">Check Your BMI After Choosing Your Session!</a></button>
          </div>
      
    </section>

    
   

<section class="section__container class__container" id="Shop">
  <h2 class="section__header">Our Online Store</h2>

  <!-- Category Filter -->
  <div class="category-filter">
    <a href="?category=clothing" class="category-btn">Clothing</a>
    <a href="?category=equipment" class="category-btn">Equipment</a>
    <a href="?category=nutrition" class="category-btn">Nutrition</a>
  </div>

  <div class="cart-icon">
  <a href="viewCart.php">
    <i class="ri-shopping-cart-line"></i>
    <span class="badge">3</span> <!-- Example badge for item count -->
  </a>
</div>


  <div class="online-store">
    <div class="class__grid">
      <?php
      // Check if any rows were returned
      if ($result->num_rows > 0) {
        // Loop through each row in the result set
        while ($row = $result->fetch_assoc()) {
          ?>
          <div class="class__card">
            <img src="assets/dot-bg.png" alt="bg" class="class__bg" />
            <!-- Use the image path from the database -->
            <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="product-image" />
            <div class="class__content">
              <!-- Display the name and price from the database -->
              <h4><?php echo $row['name']; ?></h4>
              <p><?php echo $row['price']; ?>/-</p>
              <!-- Add a button to trigger the popup -->
              <button class="online-btn" onclick="openPopup('<?php echo $row['name']; ?>', '<?php echo $row['price']; ?>')">
                Buy Now
              </button>
            </div>
          </div>
          
          <?php
        }
      } else {
        echo "<p>No items found in the selected category.</p>";
      }
      ?>
    </div>
  </div>
</section>

<?php
// Database connection details
$host = 'localhost'; // Your database host
$db = 'gymtrack'; // Your database name
$user = 'root'; // Your database username
$pass = ''; // Your database password

// Create the connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];

    // Prepare the SQL query
    $stmt = $conn->prepare("INSERT INTO cart_items (product_name, product_price, quantity, size) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        // Bind parameters to the query (string, double, int, string)
        $stmt->bind_param("sdii", $product_name, $product_price, $quantity, $size);


        // Execute the query
        if ($stmt->execute()) {
            echo "Product added to cart successfully!";
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

// Close the connection after everything is done
$conn->close();
?>

<!-- Modal for Adding to Cart -->
<div id="cartModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closePopup()">&times;</span>
    <h2>Add to Cart</h2>
    <form action="index.php.#Shop" method="POST">
      <input type="hidden" name="product_name" id="productName" />
      <input type="hidden" name="product_price" id="productPrice" />
      
      <p>Product: <span id="displayProductName"></span></p>
      <p>Price: <span id="displayProductPrice"></span>/-</p>
      
      <label for="quantity">Quantity:</label>
      <input type="number" name="quantity" id="quantity" min="1" value="1" required />
      
      <!-- Size Selection -->
      <label for="size">Select Size:</label>
      <select name="size" id="size" required>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
      </select>

      <button type="submit" class="submit-btn">Add to Cart</button>
    </form>
  </div>
</div>
<script>
  // Function to display the cart modal popup
function openCartModal(productName, productPrice) {
    // Set the product name and price in the form and display section
    document.getElementById('productName').value = productName;
    document.getElementById('productPrice').value = productPrice;
    document.getElementById('displayProductName').innerText = productName;
    document.getElementById('displayProductPrice').innerText = productPrice;

    // Show the modal
    document.getElementById('cartModal').style.display = 'block';
}

// Function to close the popup
function closePopup() {
    document.getElementById('cartModal').style.display = 'none';
}

// JavaScript to show alert on form submission
document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission for now
    
    // Get the product details
    let productName = document.getElementById('productName').value;
    let quantity = document.getElementById('quantity').value;
    let size = document.getElementById('size').value;
    
    // Show an alert to confirm the item was added to the cart
    alert(`Item added to cart:\nProduct: ${productName}\nQuantity: ${quantity}\nSize: ${size}`);
    
    // Continue with form submission after alert
    this.submit();
});

</script>
<!-- Styles for the Modal (CSS) -->
<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 400px;
    text-align: center;
  }

  .close-btn {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .close-btn:hover, .close-btn:focus {
    color: #000;
  }

  .submit-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
  }

  .submit-btn:hover {
    background-color: #0056b3;
  }
</style>


<!-- JavaScript to Handle Modal -->
<script>
  function openPopup(name, price) {
    document.getElementById('cartModal').style.display = 'block';
    document.getElementById('productName').value = name;
    document.getElementById('productPrice').value = price;
    document.getElementById('displayProductName').innerText = name;
    document.getElementById('displayProductPrice').innerText = price;
  }

  function closePopup() {
    document.getElementById('cartModal').style.display = 'none';
  }

  // Close the modal when clicking outside of it
  window.onclick = function(event) {
    if (event.target == document.getElementById('cartModal')) {
      closePopup();
    }
  }
</script>



    <section class="section__container trainer__container" id="trainer">
        <h2 class="section__header">Our Trainers</h2>
        <p class="section__description">
            Our trainers are more than just experts in exercise; they are passionate
            about helping you achieve your health and fitness goals. Our trainers
            are equipped to tailor workout programs to meet your unique needs.
        </p>
        <div class="trainer__grid">
            <?php
            // Database connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch trainers from the database
            $sql = "SELECT name, type, image, description FROM trainers";
            $result = $conn->query($sql);

            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Loop through each row in the result set
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="trainer__card">
                        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="trainer" />
                        <div class="trainer__content">
                            <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                            <h5><?php echo htmlspecialchars($row['type']); ?></h5>
                            <hr />
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <div class="trainer__socials">
                                <a href="#"><i class="ri-facebook-fill"></i></a>
                                <a href="#"><i class="ri-google-fill"></i></a>
                                <a href="#"><i class="ri-instagram-line"></i></a>
                                <a href="#"><i class="ri-twitter-fill"></i></a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No trainers found.</p>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </section>

    <section class="section__container price__container" id="price">
    <h2 class="section__header">Our Pricing</h2>
    <p class="section__description">
        Our pricing plan comes with various membership tiers, each tailored to cater to
        different preferences and fitness aspirations.
    </p>
    <div class="price__grid">
        <?php
        // Database connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch pricing plans from the database
        $sql = "SELECT name, price, planDescription, image FROM gym_plans";
        $result = $conn->query($sql);

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            // Loop through each row in the result set
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="price__card">
                    <div class="price__content">
                        <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                        <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="price" />
                        <ul>
                            <?php 
                            // Convert plan description into list items
                            $descriptions = explode("\n", $row['planDescription']);
                            foreach ($descriptions as $description) {
                                echo '<li>' . htmlspecialchars($description) . '</li>';
                            }
                            ?>
                        </ul>
                        <hr />
                        <h4><?php echo htmlspecialchars($row['price']); ?>/-</h4>
                    </div>
                    <button class="btn" onclick="openPlanModal('<?php echo htmlspecialchars($row['name']); ?>', '<?php echo htmlspecialchars($row['price']); ?>')">Join Now</button>
                </div>
                <?php
            }
        } else {
            echo "<p>No pricing plans available.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</section>

<!-- First Modal for Plan Confirmation -->
<div id="planModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('planModal')">&times;</span>
        <h2>Selected Plan</h2>
        <p style="color: black;" id="selectedPlanName"></p>
        <p style="color: black;" id="selectedPlanPrice"></p>
        <!-- Updated button to trigger JavaScript redirection -->
        <button onclick="redirectToUserInfo()">Continue</button>
    </div>
</div>

<script>
// JavaScript function to redirect to user_info.php with selected values
function redirectToUserInfo() {
    // Get the selected plan name and price
    const selectedPlan = document.getElementById('selectedPlanName').innerText;
    const selectedPrice = document.getElementById('selectedPlanPrice').innerText;

    // Build the query string
    const queryString = `?selectedPlan=${encodeURIComponent(selectedPlan)}&selectedPrice=${encodeURIComponent(selectedPrice)}`;

    // Redirect to user_info.php with query parameters
    window.location.href = "user_info.php" + queryString;
}
</script>


<script>
    // Function to open the plan modal and display the selected plan
    function openPlanModal(planName, planPrice) {
        document.getElementById('selectedPlanName').innerText = "Plan: " + planName;
        document.getElementById('selectedPlanPrice').innerText = "Price: " + planPrice + "/-";
        document.getElementById('planModal').style.display = "flex";
        
        // Store plan details in hidden fields for the next modal
        document.getElementById('selectedPlan').value = planName;
        document.getElementById('selectedPrice').value = planPrice;
    }

    // Function to open the user information modal after continuing from the plan modal
function continueToPayment() {
    closeModal('planModal');

    // Get the selected plan name and price from hidden inputs
    const selectedPlan = document.getElementById('selectedPlan').value;
    const selectedPrice = document.getElementById('selectedPrice').value;

    // Update the user information form to show the selected plan details
    document.getElementById('selectedPlanInfo').innerText = `Selected Plan: ${selectedPlan}, Price: ${selectedPrice}/-`;

    // Display the user information modal
    document.getElementById('userInfoModal').style.display = "flex";
}

    // Function to close any modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const planModal = document.getElementById('planModal');
        const userInfoModal = document.getElementById('userInfoModal');
        if (event.target == planModal) {
            closeModal('planModal');
        }
        if (event.target == userInfoModal) {
            closeModal('userInfoModal');
        }
    }
</script>

    <footer class="footer">
      <div class="section__container footer__container">
        <div class="footer__col">
          <div class="footer__logo">
            <a href="#"><img src="assets/logo.png" alt="logo" />Power</a>
          </div>
          <p>
            Take the first step towards a healthier, stronger you with our
            unbeatable pricing plans. Let's sweat, achieve, and conquer
            together!
          </p>
          <div class="footer__socials">
            <a href="#"><i class="ri-facebook-fill"></i></a>
            <a href="#"><i class="ri-instagram-line"></i></a>
            <a href="#"><i class="ri-twitter-fill"></i></a>
          </div>
        </div>
        <div class="footer__col">
          <h4>Company</h4>
          <div class="footer__links">
            <a href="#">Business</a>
            <a href="#">Franchise</a>
            <a href="#">Partnership</a>
            <a href="#">Network</a>
          </div>
        </div>
        <div class="footer__col">
          <h4>About Us</h4>
          <div class="footer__links">
            <a href="#">Blogs</a>
            <a href="#">Security</a>
            <a href="#">Careers</a>
          </div>
        </div>
        <div class="footer__col">
          <h4>Contact</h4>
          <div class="footer__links">
            <a href="#">Contact Us</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">BMI Calculator</a>
          </div>
        </div>
      </div>
      <div class="footer__bar">
        Copyright © 2023 Web Design Mastery. All rights reserved.
      </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>
