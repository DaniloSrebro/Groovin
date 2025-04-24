<?php
// Connect to your database
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "rezervacije";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the sum of brojljudi
$sql = "SELECT SUM(brojljudi) AS total FROM tocionica WHERE reservationstatus='approved'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $total_brojljudi = $row["total"];
    }
} else {
    $total_brojljudi = 0;
}

$conn->close();

$servername = "localhost";
$username = "root";
$password = "Sinke008";
$database = "ocene";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/forms/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

$isLoggedIn = isset($_SESSION["user_id"]);

// Load user info if logged in
if ($isLoggedIn) {
    $mysqli = require __DIR__ . "/forms/database.php";
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Party M Events</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/events.css">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center" style="font-style:italic;">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.html">Party M</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link scrollto" href="./index.php">Početna</a></li>
         
          
          
        
          
         
          <li class="dropdown"><a href="#"><span>Lokali</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="./restoranikafici.php">Restorani i Kafici</a></li>
              
              
            </ul>
            <li class="dropdown"><a href="#"><span>HotCue</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="./dj.php">DJ</a></li>
              <li><a class="nav-link" href="./events.php">Events</a></li>
              
            </ul>
            <li><a class="nav-link" href="./profil.php">Profil</a></li>
            
          </li>
          <li><a class="nav-link scrollto" href="./index.php#contact">Kontakt</a></li>
          <?php if($isLoggedIn): ?>
            <li><a class="getstartedout scrollto" href="./forms/logout.php">Logout</a></li>
          <?php else: ?>
            <li><a class="getstarted scrollto" href="./forms/Login.php">Login</a></li>
        <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs" style="font-style:italic">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2 style="color:white">Events</h2>
          <ol>
            <li style="color:white"><a href="./index.php">Party M</a></li>
            <li style="color:white">Events</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->



  

  </main><!-- End #main -->
  <div class="main">
    <div id="featured-events" class="section">
        <h2>Featured Events</h2>
        <div class="grid-container">
            <div class="event">
                <h3>Dino Dao Otkaz</h3>
                <p><strong>Date:</strong> July 15-18, 2024</p>
                <p><strong>Location:</strong> Tocionica</p>
                <p><strong>Description:</strong> Kiki je bila najvise tuzna od svih!</p>
            </div>
            <div class="event">
                <h3>Zeljana Radi Kao Dino</h3>
                <p><strong>Date:</strong> July 15-18, 2024</p>
                <p><strong>Location:</strong> Downtown Park</p>
                <p><strong>Description:</strong> Kikiju se jako svidja to i opet je srecna!</p>
            </div>
            <div class="event">
                <h3>Dino Dao Otkaz</h3>
                <p><strong>Date:</strong> July 15-18, 2024</p>
                <p><strong>Location:</strong> Tocionica</p>
                <p><strong>Description:</strong> Kiki je bila najvise tuzna od svih!</p>
            </div>
            <div class="event">
                <h3>Zeljana Radi Kao Dino</h3>
                <p><strong>Date:</strong> July 15-18, 2024</p>
                <p><strong>Location:</strong> Downtown Park</p>
                <p><strong>Description:</strong> Kikiju se jako svidja to i opet je srecna!</p>
            </div>
            
        </div>
    </div>
    <div id="new-foods" class="section">
        <h2>New Foods Spotlight</h2>
        <div class="grid-container">
            <div class="food-item">
                <img src="./assets/img/tocionica/toc3.jpg" alt="New Food 1">
                <h3>Novi Tripl Burger</h3>
                <p>Indulge in the rich flavors of truffle-infused risotto, topped with shaved parmesan and fresh herbs.</p>
            </div>
            <div class="food-item">
                <img src="./assets/img/tocionica/toc3.jpg" alt="New Food 1">
                <h3>Novi Tripl Burger</h3>
                <p>Indulge in the rich flavors of truffle-infused risotto, topped with shaved parmesan and fresh herbs.</p>
            </div>
            <div class="food-item">
                <img src="./assets/img/tocionica/toc3.jpg" alt="New Food 1">
                <h3>Novi Tripl Burger</h3>
                <p>Indulge in the rich flavors of truffle-infused risotto, topped with shaved parmesan and fresh herbs.</p>
            </div>
            <div class="food-item">
                <img src="./assets/img/tocionica/toc3.jpg" alt="New Food 1">
                <h3>Novi Tripl Burger</h3>
                <p>Indulge in the rich flavors of truffle-infused risotto, topped with shaved parmesan and fresh herbs.</p>
            </div>
        </div>
    </div>
    <div id="restaurant-spotlights" class="section">
        <h2>Restaurant Spotlights</h2>
        <div class="grid-container">
            <div class="restaurant">
                <img src="./assets/img/novisad2.jpg" alt="Restaurant 1">
                <h3>The Bistro</h3>
                <p><strong>Specialties:</strong> French cuisine, fine dining experience</p>
                <p><strong>Location:</strong> 123 Main Street</p>
                <p><strong>Description:</strong> Enjoy an elegant dining experience with classic French dishes and an extensive wine list.</p>
            </div>
            <div class="restaurant">
                <img src="./assets/img/novisad2.jpg" alt="Restaurant 1">
                <h3>The Bistro</h3>
                <p><strong>Specialties:</strong> French cuisine, fine dining experience</p>
                <p><strong>Location:</strong> 123 Main Street</p>
                <p><strong>Description:</strong> Enjoy an elegant dining experience with classic French dishes and an extensive wine list.</p>
            </div>
            <div class="restaurant">
                <img src="./assets/img/novisad2.jpg" alt="Restaurant 1">
                <h3>The Bistro</h3>
                <p><strong>Specialties:</strong> French cuisine, fine dining experience</p>
                <p><strong>Location:</strong> 123 Main Street</p>
                <p><strong>Description:</strong> Enjoy an elegant dining experience with classic French dishes and an extensive wine list.</p>
            </div>
            <div class="restaurant">
                <img src="./assets/img/novisad2.jpg" alt="Restaurant 1">
                <h3>The Bistro</h3>
                <p><strong>Specialties:</strong> French cuisine, fine dining experience</p>
                <p><strong>Location:</strong> 123 Main Street</p>
                <p><strong>Description:</strong> Enjoy an elegant dining experience with classic French dishes and an extensive wine list.</p>
            </div>
        </div>
    </div>
    <div id="event-reviews" class="section">
        <h2>Event Reviews and Recaps</h2>
        <div class="grid-container">
            <div class="review">
                <h3>Summer Food Festival</h3>
                <p>“Attended the festival with friends and had an amazing time trying out different dishes and listening to live music. Can't wait for next year's event!” - Sarah</p>
            </div>
            <!-- Add more event reviews here -->
        </div>
    </div>
    <div id="map" class="section">
        <h2>Interactive Map</h2>
        <!-- Add interactive map here -->
    </div>
</div>

  

  




  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Groovin</h3>
              <p>
                A108 Adam Street <br>
                NY 535022, USA<br><br>
                <strong>Phone:</strong> +1 5589 55488 55<br>
                <strong>Email:</strong> info@example.com<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Groovin</span></strong>. All Rights Reserved
      </div>

    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>