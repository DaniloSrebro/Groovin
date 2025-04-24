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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="./assets/css/restoranikafici.css" rel="stylesheet">


 


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
            <li><a class="nav-link" href="./events.php">Events</a></li>
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

<div class="row">
  <div class="col-lg-2 offset-lg-1 filterr">
    <div class="container1 content-space-1">
  <div class="row">
    <div class="ez">
      <!-- Navbar -->
      <div class="navbar-expand-lg mb-0">
        <!-- Navbar Toggle -->
        <div class="d-grid">
          <button type="button" class="navbar-toggler btn btn-white mb-0" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenuEg2" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenuEg2">
            <span class="d-flex justify-content-space-around">
              <span class="filter" style="color:black;">Filter</span>

              <span class="navbar-toggler-default">
                <i class="bi-list trilinije"></i>
              </span>
            </span>
          </button>
        </div>
        <!-- End Navbar Toggle -->

        <!-- Navbar Collapse -->
        <div id="navbarVerticalNavMenuEg2" class="collapse navbar-collapse">
          <div class="w-100">
            <!-- Form -->
            <form>
              <div class="border-bottom pb-4 mb-4">
                
                

                <div class="d-grid gap-2">
                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="menCheckbox">
                    <label class="form-check-label" for="menCheckbox">Restorani</label>
                  </div>
                  <!-- End Checkboxes -->

                  
                  

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="womenCheckbox">
                    <label class="form-check-label" for="womenCheckbox">Kafići</label>
                  </div>
                  <!-- End Checkboxes -->
                </div>
              </div>

              <div class="border-bottom pb-4 mb-4">
                <h5>Hrana</h5>

                <div class="d-grid gap-2">
                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="adidasCheckbox" >
                    <label class="form-check-label" for="adidasCheckbox">Burgeri</label>
                  </div>
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="newBalanceCheckbox">
                    <label class="form-check-label" for="newBalanceCheckbox">Specijaliteti</label>
                  </div>
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="nikeCheckbox">
                    <label class="form-check-label" for="nikeCheckbox">Suši</label>
                  </div>
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="fredPerryCheckbox">
                    <label class="form-check-label" for="fredPerryCheckbox">Rostilj</label>
                  </div>
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  
                  <!-- End Checkboxes -->
                </div>

                <!-- View More - Collapse -->
                
                <!-- End View More - Collapse -->

                <!-- Link -->
                
                <!-- End Link -->
              </div>

              <div class="border-bottom pb-4 mb-4">
                <h5>Mesto Sedenja</h5>

                <div class="d-grid gap-2">
                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="sizeSCheckbox">
                    <label class="form-check-label" for="sizeSCheckbox">Unutra</label>
                  </div>
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="sizeMCheckbox">
                    <label class="form-check-label" for="sizeMCheckbox">Napolju</label>
                  </div>
                  <!-- End Checkboxes -->

                 
                  
                  <!-- End Checkboxes -->
                </div>
              </div>

              <div class="border-bottom pb-4 mb-4">
                <h5>Vrsta</h5>

                <div class="d-grid gap-2">
                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="tshirtCheckbox">
                    <label class="form-check-label" for="tshirtCheckbox">Visoko</label>
                  </div>
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="shoesCheckbox">
                    <label class="form-check-label" for="shoesCheckbox">Nisko</label>
                  </div>
                  <!-- End Checkboxes -->

                 
                  
                  <!-- End Checkboxes -->
                </div>

                
              </div>

              <div class="border-bottom pb-4 mb-4">
                <h5>Ocene</h5>

                <div class="d-grid gap-2">
                  <!-- Checkboxes -->
                  
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="3starCheckbox">
                    <label class="form-check-label" for="3starCheckbox">
                      <span class="d-flex gap-1">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        
                        
                      </span>
                    </label>
                  </div>
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="4starCheckbox">
                    <label class="form-check-label" for="4starCheckbox">
                      <span class="d-flex gap-1">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        
                      </span>
                    </label>
                  </div>
                  <!-- End Checkboxes -->

                  <!-- Checkboxes -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="5starCheckbox">
                    <label class="form-check-label" for="5starCheckbox">
                      <span class="d-flex gap-1">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        <img src="./assets/img/star.svg" alt="Review rating" width="16">
                        
                      </span>
                    </label>
                  </div>
                  <!-- End Checkboxes -->
                </div>
              </div>

              <div class="d-grid">
                <button type="button" class="btn btn-white btn-transition">Clear all</button>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
        <!-- End Navbar Collapse -->
      </div>
      <!-- End Navbar -->
    </div>
    <!-- End Col -->
  </div>
  <!-- End Row -->
</div>
<!-- End Card Grid -->
</div>









    

    

<div class="col-lg-6">

    <div class="container">
  <div class="row">
    <a href="./tocionica/tocionica.php">
    <div class="col-lg-12 offset-lg-1 col-md-8 offset-md-4 col-sm-10 col-12" id="tocionica">
      <div class="text-container">
      <img class="top-half-image" src="./assets/img/tocionica/tocburger.jpg" alt="Your Image">
        <div class="bottom-left-text" style="font-style: normal; font-size: 20px; margin-bottom: 5px;"><em style="margin-bottom:0%">Točionica Liman</em><br>
        <img src="./assets/img/45zvezde.png" class="zvezde" width="100" alt=""><p style="font-style: normal; font-size: 14px; margin-bottom: 3px;"><small class="reviews">Google Reviews</small><br>Raspon cena: ~10$ <br> Unutra/Bašta <br>Pet Friendly <i class="material-icons" style="font-size:13px">pets</i></p></div>
        <div class="bottom-right-text"><div class="maliekran">Jela:Burgeri i Specijaliteti <br>Pića: Kraft Piva i Kokteli</div>
        </div>
      </div>
    </div></a>

    <div class="col-lg-12 offset-lg-2  col-md-8 offset-md-4 col-sm-10 col-12" style="display: none;">
    <div class="text-container">
        <div class="top-text">Top Text</div>
        <div class="bottom-left-text">Bottom Left Text</div>
        <div class="bottom-right-text">Bottom Right Text</div>
      </div>
    </div>
    <div class="col-lg-12 offset-lg-2  col-md-8 offset-md-4 col-sm-10 col-12"   style="display: none;">
    <div class="text-container">
        <div class="top-text">Top Text</div>
        <div class="bottom-left-text">Bottom Left Text</div>
        <div class="bottom-right-text">Bottom Right Text</div>
      </div>
    </div>
  </div>
</div>



<div class="container">
  <div class="row">
    <div class="col-lg-12 offset-lg-2  col-md-8 offset-md-4 col-sm-10 col-12" style="display: none;">
      <div class="text-container">
     
        <div class="top-text">Top Text</div>
        <div class="bottom-left-text">Bottom Left Text</div>
        <div class="bottom-right-text">Bottom Right Text</div>
      </div>
    </div>
    <div class="col-lg-12 offset-lg-2  col-md-8 offset-md-4 col-sm-10 col-12" style="display: none;">
    <div class="text-container">
        <div class="top-text">Top Text</div>
        <div class="bottom-left-text">Bottom Left Text</div>
        <div class="bottom-right-text">Bottom Right Text</div>
      </div>
    </div>
    <div class="col-lg-12 offset-lg-2  col-md-8 offset-md-4 col-sm-10 col-12" style="display: none;">
    <div class="text-container">
        <div class="top-text">Top Text</div>
        <div class="bottom-left-text">Bottom Left Text</div>
        <div class="bottom-right-text">Bottom Right Text</div>
      </div>
    </div>
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
    const nikeCheckbox = document.getElementById('nikeCheckbox');
    const tocionicaDiv = document.getElementById('tocionica');

    nikeCheckbox.addEventListener('change', function () {
        if (this.checked) {
            tocionicaDiv.style.display = 'none';
        } else {
            tocionicaDiv.style.display = '';
        }
    });
</script>


  <script>
var loader = document.getElementById("preloader");

window.addEventListener("load", function(){
  loader.style.display = "none";
  
})


</script>

</body>

</html>