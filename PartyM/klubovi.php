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

  <title>Klubovi</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./assets/img/logo2.png" rel="icon">
  <link href="./assets/img/logo2.png" rel="apple-touch-icon">

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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
  * {
    
    margin: 0;
    padding: 0;
    
}
body {
    font-family: 'Noto Sans JP', sans-serif;
background: black;
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
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    padding: 20px;
    font-style: normal;
}

.restaurant {
    background-color: #1e1e1e; /* Dark gray for contrast on black */
    color: #ffffff;
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 20px;
    max-width: 600px;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}



.restaurant img {
    width: 140px;
    height: 140px;
    border-radius: 10px;
    object-fit: cover;
}

.restaurant-info {
    flex: 1;
}

.restaurant-info h2 {
    font-size: 24px;
    font-weight: bold;
    margin: 0;
    color:#FF1493; /* Warm gold for a classy feel */
}

.specialties {
    font-size: 14px;
    color: #cfcfcf;
    margin: 5px 0;
}

.star-divider {
    margin-top: 10px;
}

.star-divider li {
    list-style: none;
    padding: 0;
    display: flex;
    gap: 5px;
}

.star-icon {
    color: #facc15; /* Gold stars */
    font-size: 18px;
}

@media (max-width: 768px) {
    .restaurant {
        gap: 10px;
        padding: 11px;
    }

    .restaurant img {
        width: 90px;
        height: 120px;
        margin-left: 4px;
    }

    .restaurant-info h2 {
        font-size: 18px;
    }

    .specialties {
        font-size: 12px;
    }

    .restaurant-info p {
        font-size: 12px;
    }

    .star-icon {
        font-size: 15px;
    }
}
  #preloader{
    background: #000 url(./assets/img/preloader.gif) no-repeat center center;
    background-size: 20%;
    height: 100vh;
    width: 100%;
    position: fixed;
    z-index: 99999;
    opacity: 1; /* Fully visible */
    transition: opacity 0.5s ease;
  }
  @media only screen and (max-width: 800px) {
    #preloader{  
      background-size: 100%;
    }
    #header .logo img {
            max-height: 40px;
          }
  }
  
    
    
 </style>


  



</head>


<body>

<div id="preloader">
  
  </div>

  <!-- ======= Header ======= -->
 <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="./index.php" class="logo"><img src="./assets/img/logo3.png" alt="" class="img-fluid"></a>
      

      <nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link scrollto" href="./home">Početna</a></li>
         
          
          
        
          
         
          <li class="dropdown  active"><a href="#"><span>Lokali</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="./restoranikafici">Restorani i Kafici</a></li>
              
              
            </ul>
            <li class="dropdown"><a href="#"><span>HotCue</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="./dj">DJ</a></li>
           
              
            </ul>
            
            <li><a class="nav-link" href="./profil">Profil</a></li>
            
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
          <h2 style="color:white">Klubovi</h2>
          <ol>
            <li style="color:white"><a href="home">Party M</a></li>
            <li style="color:white">Klubovi</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->




    
	<a href="./cubalibre/cubalibre.php"><div class="restaurant-container">
  <div class="restaurant">
    <img src="./assets/img/klubs.jpg" alt="Restaurant Image">
    <div class="restaurant-info">
      <h2>Cuba Libre</h2>
      </a><p class="specialties"> Night Club  |  <a href="./djs/mikula.php">DJ Zaun</a> |  23:00</p>
	  <p>Klub koji pretvara deluziju u realnost. Takodje ludnica stalno i kosntantnoo.</p>
      <div class="star-divider">
        <li>
          <i class="bi bi-star-fill star-icon"></i>
          <i class="bi bi-star-fill star-icon"></i>
          <i class="bi bi-star-fill star-icon"></i>
          <i class="bi bi-star-fill star-icon"></i>
          <i class="bi bi-star star-icon"></i>
        </li>
      </div>
    </div>
  </div>
</div>

    




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
<br>
<br>
<br>
<br>
<br>
<br>
















</main>







  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Party M <img src="./assets/img/logo1.png" alt="" style="width:70px; height:65px;"></h3>
              
              <p>
                <strong style="color:white">Informacije:</strong> info@partym.rs<br>
                <strong style="color:white">Saradnja:</strong> partner@partym.rs<br>
              </p>
              
            </div>
          </div>

          <div class="col-lg-3 offset-lg-6 col-md-6 footer-links">
            <h4>Nasi Servisi</h4>
            <ul>
              
              <li><i class="bx bx-chevron-right"></i> <a href="#">Restorani/Kafici</a></li>
              
              
            </ul>
            <br>
            <h4>Partneri:</h4>
            <ul>
              
              <li><i class="bx bx-chevron-right"></i> <a href="./tocionica/tocionica">Točionica</a></li>
              
              
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
       
        Designed by Zy
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