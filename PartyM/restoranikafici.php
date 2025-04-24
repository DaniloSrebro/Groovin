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

  <title>Restorani i Kafići</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logopartym.png" rel="icon">
  <link href="assets/img/logopartym.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Anta&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">


  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">



 <style>
  * {
    
    margin: 0;
    padding: 0;
    
}
body {
    font-family: 'Noto Sans JP', sans-serif;
	background: linear-gradient(to bottom, #ffffff, #c0c0c0);
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
    
   
             
              
            font-style: italic;
            overflow-x: hidden;
  }
  
		#preloader{
  background: #000 url(./assets/img/preloader.gif) no-repeat center center;
  background-size: 20%;
  height: 100vh;
  width: 100%;
  position: fixed;
  z-index: 100;
  opacity: 1; /* Fully visible */
  transition: opacity 0.5s ease;
}



.restaurant-container {
  width: 100%;
  display: flex;
  justify-content: center;
  margin: 20px 0;
  
}

.restaurant {
  background-color: #ffffff;
  border: 1px solid #ddd;
  display: flex;
  width: 90%;
  max-width: 800px;
  position: relative; /* Set relative positioning for absolute children */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
  border-top-right-radius: 8px;
}

.restaurant img {
	width: 40%; /* Width of the image */
    object-fit: cover; /* Maintain aspect ratio */
    border-radius: 8px; /* Slight rounding for blending effect */
    margin-right: 15px; /* Space between image and text */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

.restaurant-info {
  padding: 20px;
  flex: 1;
  position: relative;
  font-style: normal; /* Relative to contain absolutely positioned stars */
}

.restaurant-info h2 {
  color: black; /* Main site color */
  font-size: 30px; /* Slightly larger font size */
  font-weight: 400; /* Make the text bolder */
  letter-spacing: 1px; /* Adds spacing between letters */
  margin-bottom: 10px;
   /* Make text all uppercase for a modern look */
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Add a soft shadow for depth */
}

.restaurant-info p {
  color: #333;
  font-size: 20px;
  font-weight: 400;
   /* Make the text bolder */
  line-height: 1.5;
  margin-bottom: 10px;
}

.restaurant-info p:nth-child(3) {
	font-style: italic;
	margin-top: 10px;
  
  color: black; /* Site color */
  font-size: 20px;
  font-weight: 400; /* Make the text bolder */
}

/* Star container positioning */

/* Star Divider with a flag-style effect */
.star-divider {
  position: absolute;
  bottom: -37px;
  right: 0px; /* Moves the divider outside the box */
  background-color: #4b137d;
  padding: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  color: #fff;
  border-bottom-left-radius: 15px; /* Add rounded bottom-left corner */
  border-bottom-right-radius: 15px; /* Add rounded bottom-right corner */
}

.star-divider li {
  list-style: none;
  display: flex;
}

.star-icon {
  color: #f0c419; /* Gold color for stars */
  font-size: 18px;
  margin-right: 2px;
}

@media screen and (max-width: 768px) {
	.star-divider {
  position: absolute;
  bottom: -32px;
  right: 0px; /* Moves the divider outside the box */
  background-color: #4b137d;
  padding: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  color: #fff;
  border-bottom-left-radius: 15px; /* Add rounded bottom-left corner */
  border-bottom-right-radius: 15px; /* Add rounded bottom-right corner */
}

	.star-icon {
  color: #f0c419; /* Gold color for stars */
  font-size: 15px;
  margin-right: 2px;
}

.restaurant-info {
  padding: 10px;
  flex: 1;
  position: relative;
  font-style: normal; /* Relative to contain absolutely positioned stars */
}

.restaurant-info h2 {
  color: black; /* Main site color */
  font-size: 24px; /* Slightly larger font size */
  font-weight: 400; /* Make the text bolder */
  letter-spacing: 1px; /* Adds spacing between letters */
  margin-bottom: 10px;
   /* Make text all uppercase for a modern look */
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Add a soft shadow for depth */
}

.restaurant-info p {
  color: #333;
  font-size: 16px;
  font-weight: 400; /* Make the text bolder */
  line-height: 1.5;
  margin-bottom: 10px;
}

.restaurant-info p:nth-child(3) {

  color: black; /* Site color */
  font-size: 15px;
  font-weight: 400; /* Make the text bolder */
}
}
.specialties {
    font-weight: 600; /* Make it bold */
    color: #4b137d; /* Match main site color */
    font-size: 16px; /* Slightly larger font size */
    margin: 5px 0; /* Spacing around the paragraph */
    position: relative; /* Positioning for pseudo-elements */
}

.specialties::before {
    content: ''; /* Create a decorative element */
    position: absolute; /* Position it relative to the paragraph */
    left: -10px; /* Adjust left positioning */
    top: 50%; /* Center vertically */
    transform: translateY(-50%); /* Adjust for centering */
    width: 4px; /* Line width */
    height: 20px; /* Line height */
    background-color: #4b137d; /* Line color */
    border-radius: 2px; /* Rounded edges */
}
 </style>


</head>

<body>

<div id="preloader">
</div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="./index.php">Party M</a></h1>
      

      <nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link scrollto" href="./index.php">Početna</a></li>
         
          
          
        
          
         
          <li class="dropdown  active"><a href="#"><span>Lokali</span> <i class="bi bi-chevron-down"></i></a>
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
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2 style="color:white">Restorani/Kafići</h2>
          <ol>
            <li style="color:white"><a href="index.php">Party M</a></li>
            <li style="color:white">Restorani/Kafići</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->





	<a href="./tocionica/tocionica.php"><div class="restaurant-container">
  <div class="restaurant">
    <img src="./assets/img/tocionica/glavnatoc.jpg" alt="Restaurant Image">
    <div class="restaurant-info">
      <h2>Точионица Паб</h2>
      <p class="specialties">Burgeri i Specijaliteti  |  ~1000 din</p>
	  <p>Restoran specijalizovan za sočne burgere i ukusnu piletinu.</p>
      <div class="star-divider">
        <li>
          <i class="bi bi-star-fill star-icon"></i>
          <i class="bi bi-star-fill star-icon"></i>
          <i class="bi bi-star-fill star-icon"></i>
          <i class="bi bi-star-fill star-icon"></i>
          <i class="bi bi-star-half star-icon"></i>
        </li>
      </div>
    </div>
  </div>
</div></a>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>















</main>





<a href="https://www.freepik.com/free-vector/copy-space-wavy-white-background-layers_12348956.htm#fromView=search&page=1&position=18&uuid=21841269-3eff-43b0-a638-77b12bf99736">Image by freepik</a>
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Party M <img src="./assets/img/logopartym.png" alt="" style="width:70px; height:70px;"></h3>
              
              <p>
                <strong>Email:</strong> info@partym.rs<br>
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

          <div class="col-lg-3 offset-lg-6 col-md-6 footer-links">
            <h4>Nasi Servisi</h4>
            <ul>
              
              <li><i class="bx bx-chevron-right"></i> <a href="./restoranikafici.php">Restorani/Kafici</a></li>
              
              
            </ul>
            <br>
            <h4>Partneri:</h4>
            <ul>
              
              <li><i class="bx bx-chevron-right"></i> <a href="./tocionica/tocionica.php">Točionica</a></li>
              
              
            </ul>
            
          </div>

          

        </div>
      </div>
    </div>
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Party M</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
       
        Designed by Zaun
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

  

  <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterToggle = document.querySelector('.filter-toggle');
            const filterSidebar = document.querySelector('.filter-sidebar');
            const slides = document.querySelectorAll('.slider img');
            const prevButton = document.querySelector('.slider-button.prev');
            const nextButton = document.querySelector('.slider-button.next');
            let currentSlide = 0;

            filterToggle.addEventListener('click', () => {
                filterSidebar.classList.toggle('active');
            });

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }

            function prevSlide() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            }

            nextButton.addEventListener('click', nextSlide);
            prevButton.addEventListener('click', prevSlide);

            showSlide(currentSlide);
        });
    </script>


  


  <script>
var loader = document.getElementById("preloader");

window.addEventListener("load", function() {
  // Fade out the loader
  loader.style.opacity = "0";
  
  // Wait for the transition to complete before hiding it
  setTimeout(function() {
    loader.style.display = "none";
  }, 500); // Match this time to your CSS transition duration
});
</script>

</body>

</html>