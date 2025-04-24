<?php

include 'dbconnect.php';

$conn = new mysqli($servername, $username, $password, $database);

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

session_start();

if (isset($_GET['error']) && $_GET['error'] === '322') {
  $error_message = 'Token is missing. Please try again.';
} else if(isset($_GET['error']) && $_GET['error'] === '133') {
  $error_message = 'Not logged in. Please try again.';
}
else if(isset($_GET['error']) && $_GET['error'] === '411') {
  $error_message = 'Spam detected.';
}
else {
  $error_message = ''; // Set to empty if there is no CSRF error
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a 32-byte CSRF token
}


$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];   // Za after logina

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "../../forms/database.php";
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

$isLoggedIn = isset($_SESSION["user_id"]);

// Load user info if logged in
$user_email = "";
$user_name = "";
$user_phone = "";

if ($isLoggedIn) {
    $mysqli = require __DIR__ . "../../forms/database.php";
    
    $sql = "SELECT username, email, phone_number FROM user WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user_email = $user['email'] ?? "";
            $user_name = $user['username'] ?? "";
            $user_phone = $user['phone_number'] ?? "";
        }
        
        $stmt->close();
    }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Party M - Točionica</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/logopartym.png" rel="icon">
  <link href="../assets/img/logopartym.png" rel="apple-touch-icon">

 
  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
 
  <link href="../assets//vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets//vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
 

  

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  

 <style>
  body {
    background-color: #000;
    color: #fff;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.restaurant-page {
    max-width: 900px;
    margin: auto;
    padding: 20px;
}

.restaurant-header {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px;
    background: linear-gradient(to right, #1a1a1a, #222);
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.header-image img {
    width: 160px;
    height: 160px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(255, 255, 255, 0.1);
}

.restaurant-details {
    flex: 1;
}

h1 {
    font-size: 1.8rem;
    margin-bottom: 5px;
}

.specialties {
    font-size: 1rem;
    color: #bbb;
}

.star-divider {
    margin-top: 8px;
}

.stars {
    color: gold;
    font-size: 1.5rem;
    letter-spacing: 2px;
}

.rating {
    font-size: 1rem;
    color: #bbb;
    margin-left: 5px;
}

.menu-section, .info-section, .reviews-section, .reservation-form {
    background: #111;
    padding: 20px;
    margin-top: 20px;
    border-radius: 10px;
}

.h2 {
    color: #e91e63;
    border-bottom: 2px solid #e91e63;
    padding-bottom: 5px;
}

.menu-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #444;
}

.price {
    color: #e91e63;
    font-weight: bold;
}

.review {
    background: #222;
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.input, button {
    padding: 10px;
    border-radius: 5px;
    border: none;
    font-size: 1rem;
    
}

.input {
    background: #222;
    color: #fff;
    
}

.main-button-icon{
  background: #e91e63;
    color: white;
    cursor: pointer;
    font-weight: bold;
}

.main-button-icon:hover{
  background: #c2185b;
}



.additional-options-btn {
    background: none;
    border: none;
    color:rgb(143, 143, 143); /* Button text color (use your site's color) */
    font-size: 16px;
    cursor: pointer;
    padding: 5px;
}

.additional-options-btn .plus-symbol {
    font-size: 18px; /* Adjust size of the plus symbol */
    margin-right: 8px; /* Space between the symbol and the text */
}

.additional-options-btn:hover {
    text-decoration: underline;
}

 </style>

</head>

<body>
<div id="preloader">
  
  </div>
 

  <header id="header" class="fixed-top d-flex align-items-center" style="font-style:italic">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="../index.php">Party M</a></h1>
      

      <nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link scrollto" href="../index.php">Početna</a></li>
         
          
          
        
          
         
          <li class="dropdown  active"><a href="#"><span>Lokali</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="../restoranikafici.php">Restorani i Kafici</a></li>
              
              
            </ul>
            <li class="dropdown"><a href="#"><span>HotCue</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="../dj.php">DJ</a></li>
              <li><a class="nav-link" href="../events.php">Events</a></li>
              
            </ul>
            <li><a class="nav-link" href="../profil.php">Profil</a></li>
            
          </li>
          <li><a class="nav-link scrollto" href="../index.php#contact">Kontakt</a></li>
          <?php if($isLoggedIn): ?>
            <li><a class="getstartedout scrollto" href="../forms/logout.php">Logout</a></li>
          <?php else: ?>
            <li><a class="getstarted scrollto" href="../forms/Login.php">Login</a></li>
        <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center" style="color: white;font-style:italic">
          <h2>Točionica</h2>
          <ol>
            <li><a href="../index.php">Party M</a></li>
            <li><a href="../restoranikafici.php">Restorani/Kafići</a></li>
            <li>Točionica</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

 <main id="main">

 <div class="restaurant-page">
        <!-- Header with image and details -->
        <div class="restaurant-header">
            <div class="header-image">
                <img src="../assets/img/tocionica/glavnatoc.jpg" alt="Точионица Паб">
            </div>
            <div class="restaurant-details">
                <h1>Точионица Паб</h1>
                <p class="specialties">Burgeri i Specijaliteti | ~1000 din</p>
                <p>Restoran specijalizovan za sočne burgere i ukusnu piletinu.</p>
                <div class="star-divider">
                    <span class="stars">
                        ★★★★★
                    </span>
                    <span class="rating">(4.5/5)</span>
                </div>
            </div>
        </div>
        
        
        <!-- Menu Section -->
        <div class="menu-section">
            <h2 class="h2">Naš Meni</h2>
            <div class="menu-item">
                <h3>Cheeseburger</h3>
                <p>Sočno meso, sir, salata, paradajz, domaći sos</p>
                <span class="price">750 din</span>
            </div>
            <div class="menu-item">
                <h3>Pileći Burger</h3>
                <p>Hrskava piletina, zelena salata, majonez</p>
                <span class="price">800 din</span>
            </div>
            <div class="menu-item">
                <h3>Pivo (0.5L)</h3>
                <p>Domaće i strano pivo</p>
                <span class="price">350 din</span>
            </div>
        </div>
        
        <!-- Opening Hours & Location -->
        <div class="info-section">
            <h2 class="h2">Radno Vreme</h2>
            <p>Ponedeljak - Nedelja: 12:00 - 00:00</p>
            <h2>Lokacija</h2>
            <p>Bulevar Oslobođenja 34, Novi Sad</p>
        </div>
        
        <!-- Customer Reviews -->
        <div class="reviews-section">
            <h2 class="h2">Recenzije</h2>
            <div class="review">
                <p><strong>Marko P.</strong>: "Najbolji burger u gradu! Preporuka!"</p>
            </div>
            <div class="review">
                <p><strong>Jovana M.</strong>: "Odlična usluga i fenomenalna atmosfera!"</p>
            </div>
        </div>
        
        <!-- Reservation Form -->
        <div class="reservation-form">
    <h2 class="h2">Napravite Rezervaciju</h2>
    <form action="./process-reservation_tocionica.php" method="POST">
        <?php if ($error_message): ?>
            <p style="color:red;text-align:center;padding:0; margin-bottom:20px;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <label for="mestosedenja">Mesto sedenja:</label>
        <select class="input" onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" id="mestosedenja" name="mestosedenja" class="form-control">
            <option>Mesto Sedenja</option>
            <option>Unutra</option>
            <option>Bašta</option>
        </select>

        <label for="brojljudi">Broj osoba:</label>
        <select class="input" onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" id="brojljudi" name="brojljudi" class="form-control">
            <option value="number-guests">Broj Gostiju</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
        </select>

        <label for="zadatum">Datum:</label>
        <input class="input" onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" class="form-control" id="zadatum" name="zadatum" type="date" required min="<?php echo date('Y-m-d'); ?>" 
               max="<?php echo date('Y-m-d', strtotime('+6 days')); ?>" value="<?php echo date('Y-m-d'); ?>">

        <label for="vremedolaska">Vreme dolaska:</label>
        <input class="input" onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" class="form-control" type="time" id="vremedolaska" name="vremedolaska" required min="08:00" max="23:59">

        <label for="additional-options">
            <button type="button" onclick="toggleAdditionalOptions()" class="additional-options-btn">
            Dodatne opcije <i class="bi bi-arrow-down-short"></i> 
            </button>
        </label>

        <div id="additional-options" style="display: none;">
            <label for="sedenje">Vrsta sedenja:</label>
            <select class="input" onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" id="sedenje" name="sedenje" class="form-control" required>
                <option>Vrsta Sedenja</option>
                <option selected>Nisko</option>
                <option>Visoko</option>
            </select><br><br>

            <label for="vrstarez">Vrsta rezervacije:</label>
            <select class="input" onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" id="vrstarez" name="vrstarez" class="form-control" required>
                <option>Vrsta Rezervacije</option>
                <option>Piće</option>
                <option selected>Piće i Hrana</option>
            </select>
        </div>


        <input type="hidden" name="user_email" value="<?php echo htmlspecialchars($user_email); ?>">
        <input type="hidden" name="ime" value="<?php echo htmlspecialchars($user_name); ?>">
        <input type="hidden" name="brojtelefona" value="<?php echo htmlspecialchars($user_phone); ?>">

        
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <input type="text" name="honeypott" style="display:none;" value="">

        <button type="submit" id="form-submit" class="main-button-icon" <?php if (!$isLoggedIn) echo 'disabled'; ?>>Napravi Rezervaciju</button>
    </form>
</div>











                          </main>
  




  <!-- ======= Footer ======= -->
  <footer id="footer" style="font-style:italic">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Party M <img src="../assets/img/logopartym.png" alt="" style="width:70px; height:70px;"></h3>
              
              <p>
                <strong>Email:</strong> info@partym.rs<br>
              </p>
              <div class="social-links mt-3">
                <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bi bi-skype"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 offset-lg-6 col-md-6 footer-links">
            <h4>Nasi Servisi</h4>
            <ul>
              
              <li><i class="bi bi-arrow-right-short"></i> <a href="../restoranikafici.php">Restorani/Kafici</a></li>
              
              
            </ul>
            <br>
            <h4>Partneri:</h4>
            <ul>
              
              <li><i class="bi bi-arrow-right-short"></i> <a href="#">Točionica</a></li>
              
              
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
    // Get current day
    var today = new Date().getDay();
    var days = ["Nedelja", "Ponedeljak", "Utorak", "Sreda", "Četvrtak", "Petak", "Subota"];

    // Find the corresponding span element and add the highlight class
    var spans = document.querySelectorAll("#working-hours span");
    for (var i = 0; i < spans.length; i++) {
        if (spans[i].textContent.includes(days[today])) {
            spans[i].classList.add("highlight");
        }
    }
</script>

  <!-- Vendor JS Files -->
  <script src="../assets/"></script>
  <script src="../assets//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets//vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets//vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets//vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets//vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets//js/main.js"></script>

  <!-- <?php if (!$isLoggedIn) : ?>
        <script>

            window.onload = function() {
                alert("Za rezervaciju morate biti ulogovani.");
            }
        </script>
    <?php endif; ?> -->


    <script>
    // Get the current time
    var currentTime = new Date();

    // Add 2 hours to the current time
    currentTime.setHours(currentTime.getHours() + 2);

    // Format the time as hh:mm
    var hours = ('0' + currentTime.getHours()).slice(-2);
    var minutes = ('0' + currentTime.getMinutes()).slice(-2);

    // Set the value of the input field to the calculated time
    document.getElementById('vremedolaska').value = hours + ':' + minutes;
</script>

  <!-- <script>
document.querySelector('.gotogalerija').addEventListener('click', function() {
  const gallerySection = document.querySelector('#portfolio-details');
  if (gallerySection) {
    gallerySection.scrollIntoView({ behavior: 'smooth' });
  }
});
  </script> -->

  <script>
    function toggleAdditionalOptions() {
    var optionsDiv = document.getElementById("additional-options");
    if (optionsDiv.style.display === "none" || optionsDiv.style.display === "") {
        optionsDiv.style.display = "block";
    } else {
        optionsDiv.style.display = "none";
    }
}
  </script>


<script>
  function proverilogin(x){
    if (x == 1){
      alert("Morate biti ulogovani da biste rezervisali.");
      preventDefault();
    }
  }
</script>






  

</body>

</html>