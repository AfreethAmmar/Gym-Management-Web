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
          background-color: #007BFF;
          color: white;
          text-decoration: none;
          border-radius: 5px;
      }

      .category-btn:hover {
          background-color: #0056b3;
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
  padding: 5px 150px;
  font-size: large;
  font-weight: 800;
  background-color: #89131b;
  color: white;
}


    </style>
  </head>
  <body>
    <header class="header">
      <nav>
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
          <li class="link"><button class="btn">Contact Us</button></li>
        </ul>
      </nav>
      <div class="section__container header__container" id="home">
        <div class="header__image">
          <img src="images/bodybuilding_PNG23.png" alt="header" />
        </div>
        <div class="header__content">
          <h4>Build Your Body &</h4>
          <h1 class="section__header">Shape Yourself!</h1>
          <p>
            Unleash your potential and embark on a journey towards a stronger,
            fitter, and more confident you. Sign up for 'Make Your Body Shape'
            now and witness the incredible transformation your body is capable
            of!
          </p>
          <div class="header__btn">
            <a href="lo.php"><button class="btn" >Login</button></a>
          </div>
        </div>
      </div>
    </header>

    <section class="section__container about__container" id="about">
      <div class="about__image">
        <img class="about__bg" src="assets/dot-bg.png" alt="bg" />
        <img src="images/Gym-structure-1080x675.png" alt="about" />
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
      </div>
      
      
<section class="section__container class__container" id="class">
<h2 class="section__header">Our Online Store</h2>

<!-- Category Filter -->
<div class="category-filter">
    <a href="?category=clothing" class="category-btn">Clothing</a>
    <a href="?category=equipment" class="category-btn">Equipment</a>
    <a href="?category=nutrition" class="category-btn">Nutrition</a>
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
                        <!-- Add a link to the order page -->
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
            Our pricing plan comes with various membership tiers, each tailored to
            cater to different preferences and fitness aspirations.
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
    <footer class="footer">
      <div class="section__container footer__container">
        <div class="footer__col">
          <div class="footer__logo">
          <a href="#"><img src="images/4jf16gol.png" alt="logo" height="35px" width="300px" />GymTrack</a>
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
