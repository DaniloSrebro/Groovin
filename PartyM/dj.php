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

  <title>Party M DJ</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="./assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="./assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="./assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
body {
    background: -webkit-linear-gradient(left, #800080, #000000);
    font-family: 'Arial', sans-serif;
    color: #fff;
    margin: 0;
    padding: 0;
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

  .main {
    padding: 2em;
    padding-top: 0em;
    
    
    border-radius: 15px;
    
    max-width: 1000px;
    margin: 2em auto;
    margin-top: 1em;
   
  }

  @media only screen and (max-width: 800px) {
    .main {
    padding: 2em;
    padding-top: 0em;  
    background: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-top: none;
    max-width: 1000px;
    margin: 2em auto;
    
    margin-top: 0em;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

 
          
        }

        #top-djs {
  text-align: center;
  padding-top: 2em;
  padding-bottom: 0em;
}

.dj-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2em;
}

.dj {
  position: relative; /* To position text inside the DJ card */
  background: rgba(0, 0, 0, 0.7);
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  transition: transform 0.3s, box-shadow 0.3s;
}

.dj:hover {
  transform: translateY(-10px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
}

.dj img {
  width: 100%;
  height: auto;
  display: block;
}

.dj-info {
  position: absolute; /* Makes it an overlay */
  bottom: 0; /* Align to bottom */
  left: 0; /* Align to left */
  width: 100%;
  padding: 1em;
  background: rgba(0, 0, 0, 0.1); /* Semi-transparent background for better readability */
  color: white;
  text-align: left;
}

.dj-info h3 {
  margin-top: 0;
  font-size: 1.5em;
  color: #fff;
  transition: color 0.2s;
}

.dj-info h3 a {
  color: inherit;
  text-decoration: none;
}

.dj-info h3 a:hover {
  color: #007BFF;
}

.dj-info p {
  margin: 0.5em 0 0;
  font-size: 1em;
  color: #ddd;
}

.genres {
  margin: 0.5em 0 0;
  padding: 0;
  list-style: none;
  display: flex;
  gap: 0.5em;
}

.genres li {
  padding: 0.3em 0.5em;
  background: -webkit-linear-gradient(left, #800080, #000000);
  color: #fff;
  border-radius: 5px;
  font-size: 0.9em;
}

.dj video,
.dj img {
    display: block; /* Ensure no extra spacing around elements */
    width: 100%; /* Fill the full width of the parent */
    height: 100%; /* Fill the full height of the parent */
    object-fit: cover; /* Ensure the content covers the entire container */
    border-radius: 8px; /* Optional: match the image styling */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional: add shadow for better aesthetics */
    transition: opacity 0.5s ease; /* Smooth fade effect */
    position: absolute; /* Position the video or image absolutely */
    top: 0;
    left: 0;
}

.dj {
    position: relative; /* Set parent to relative for proper positioning of children */
    overflow: hidden; /* Ensure content doesn't overflow */
    width: 100%; /* Set parent width */
    height: auto; /* Allow responsive height adjustment */
    aspect-ratio: 16 / 9; /* Optional: Keep the parent at a specific aspect ratio */
}

.dj .fade {
    opacity: 0; /* Start hidden */
}

/* Optional hover effect for the parent div */

  </style>
</head>

<div id="preloader">
  
  </div>

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
          <h2 style="color:white">Mixer</h2>
          <ol>
            <li style="color:white"><a href="./index.php">Party M</a></li>
            <li style="color:white">Mixer</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->


    <main class="main">



    <section id="top-djs">
  <div class="dj-list">
  <?php
// Database connection parameters
$servername = "localhost";  // Your database server (commonly localhost)
$username = "root";         // Your database username
$password = "Sinke008";     // Your database password (for local MySQL it's often empty)
$dbname = "login_db";       // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all DJs from the database
$sql = "SELECT id, username, genre_1, genre_2, genre_3, profile_picture, live FROM dj WHERE verified = '1'";
$result = $conn->query($sql);

// Check if DJs were found
if ($result->num_rows > 0) {
    // Loop through the DJs and create a dynamic block for each one
    while ($dj = $result->fetch_assoc()) {
        ?>
        <div class="dj" onmouseover="switchToVideo(this)" onmouseout="switchToImage(this)" data-video="./assets/video/blender.mp4" data-img="./djs/uploads/profile_pictures/<?php echo htmlspecialchars($dj['profile_picture']); ?>">    
            <img src="./djs/uploads/profile_pictures/<?php echo htmlspecialchars($dj['profile_picture']); ?>" alt="<?= htmlspecialchars($dj['username'] ?? ''); ?> Photo">
            <div class="dj-info">
            <h3>
                <a href="./djs/profile.php?id=<?= $dj['id']; ?>"><?= htmlspecialchars($dj['username'] ?? ''); ?></a> 
            </h3>
                <ul class="genres">
                    <li><?= htmlspecialchars($dj['genre_1'] ?? ''); ?></li>
                    <li><?= htmlspecialchars($dj['genre_2'] ?? ''); ?></li>
                    <li><?= htmlspecialchars($dj['genre_3'] ?? ''); ?></li>
                    <?php 
                if ($dj['live'] == 1) {
                    echo '<span style="background-color:rgba(244, 67, 54, 0.7); color: white; padding: 2.5px 5px;  border-radius: 5px; margin-left: auto; display: inline-block;">Live</span>';
                }
                ?>
                        
                    
                </ul>
            </div>
        </div>
        <?php
    }
} else {
    // No DJs found
    echo "No DJs found.";
}

// Close the database connection
$conn->close();
?>
  </div>
</section>







  </main>
  

  

  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>


  




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
  <script src="./assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="./assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="./assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="./assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="./assets/js/main.js"></script>

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


<script>
  function switchToVideo(element) {
    const img = element.querySelector("img");
    const video = document.createElement("video");

    // Retrieve video source from data attribute
    const videoSrc = element.getAttribute("data-video");

    // Set video attributes
    video.src = videoSrc;
    video.autoplay = true;
    video.muted = true; // Optional: Mute the video
    video.loop = true; // Optional: Loop the video
    video.className = img.className; // Inherit class styles
    video.classList.add("fade"); // Add fade class initially

    // Replace the image with the video
    element.replaceChild(video, img);

    // Trigger fade-in effect
    setTimeout(() => {
        video.classList.remove("fade");
    }, 10); // Short delay to apply the CSS transition
}

function switchToImage(element) {
    const video = element.querySelector("video");
    const img = document.createElement("img");

    // Retrieve image source from data attribute
    const imgSrc = element.getAttribute("data-img");

    // Set image attributes
    img.src = imgSrc;
    img.alt = "DJ Photo";
    img.className = video.className; // Inherit class styles
    img.classList.add("fade"); // Add fade class initially

    // Replace the video with the image
    element.replaceChild(img, video);

    // Trigger fade-in effect
    setTimeout(() => {
        img.classList.remove("fade");
    }, 10); // Short delay to apply the CSS transition
}
</script>

</body>

</html>