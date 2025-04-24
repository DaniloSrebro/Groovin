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

  <title>Party M - Cuba Libre</title>
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

.club-page {
    max-width: 900px;
    margin: auto;
    padding: 20px;
}

.club-header {
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

.club-details {
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

.reservation-section, .dj-lineup-section, .events-section, .drinks-menu-section, .info-section, .reviews-section {
    background: #111;
    padding: 20px;
    margin-top: 20px;
    border-radius: 10px;
}

.h2 {
    color: #e91e63;
    border-bottom: 2px solid #e91e63;
    padding-bottom: 5px;
    margin-bottom: 15px;
}

.dj-item {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #222;
    padding: 20px;
    margin-bottom: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
   
}

.dj-item img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
}

.dj-item:hover {
    
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.7);
}

.dj-item h3 {
    margin: 0;
    font-size: 1.5rem;
    color: #ff4081;
}

.dj-item p {
    margin: 5px 0;
    color: #ccc;
}

.set-time {
    color: #ff4081;
    font-weight: bold;
    margin-top: 5px;
    font-size: 1rem;
}

.set-time, .event-date, .price {
    display: block;
    color: #e91e63;
    font-weight: bold;
    margin-top: 5px;
}

.reservation-section, .events-section, .drinks-menu-section, .info-section, .reviews-section {
    background: #1a1a1a;
    padding: 20px;
    margin: 20px 0;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.h2 {
    color: #ff4081;
    font-size: 1.8rem;
    margin-bottom: 15px;
    border-bottom: 2px solid #ff4081;
    padding-bottom: 5px;
}

.event-item, .menu-item, .review {
    background: #222;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
}

.event-item h3, .menu-item h3 {
    color: #ff4081;
    margin: 0 0 5px;
    font-size: 1.4rem;
}

.event-item p, .menu-item p {
    color: #ccc;
    margin: 5px 0;
}

.event-date, .price {
    color: #ff4081;
    font-weight: bold;
    font-size: 1rem;
}

.review p {
    color: #ddd;
    margin: 0;
}

.info-section h2 {
    color: #ff4081;
    font-size: 1.5rem;
    margin-top: 15px;
}

.info-section p {
    color: #ccc;
    font-size: 1rem;
    margin: 5px 0;
}


/* Table container (position relative to the image) */
.table-container {
    position: relative;
    width: 100%;
    display: none;
}

/* Image in the background */
.table-container img {
    width: 100%;
    border-radius: 5%;
}

/* Style for table buttons */
.table {
    position: absolute;
    font-size: 20px;
    font-weight: bold;
    color: white;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

/* Specific table button positioning */
.table1 {
    top: 20%; /* Adjust as needed */
    left: 15%; /* Adjust as needed */
}

.table2 {
    top: 40%; /* Adjust as needed */
    left: 30%; /* Adjust as needed */
}

.table3 {
    top: 60%; /* Adjust as needed */
    left: 45%; /* Adjust as needed */
}

.table4 {
    top: 80%; /* Adjust as needed */
    left: 60%; /* Adjust as needed */
}

/* Media queries for smaller screens */
@media (max-width: 768px) {
    .table1 {
        top: 15%;
        left: 10%;
    }
    .table2 {
        top: 35%;
        left: 25%;
    }
    .table3 {
        top: 55%;
        left: 40%;
    }
    .table4 {
        top: 75%;
        left: 55%;
    }
}
        

#reservation-form {
    margin-top: 20px; /* Space between table selection and form */
}

/* Modal (background overlay) */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5); /* Slightly dark overlay */
    padding-top: 60px;
    backdrop-filter: blur(10px); /* Frosted glass effect for background */
}

/* Modal content (the actual box) */
.modal-content {
    background: rgba(255, 255, 255, 0.1); /* Transparent white background */
    border-radius: 10px; /* Rounded corners */
    margin: 5% auto;
    padding: 30px;
    border: 1px solid rgba(255, 255, 255, 0.2); /* Subtle white border */
    width: 80%;
    max-width: 500px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Soft shadow for depth */
    backdrop-filter: blur(15px); /* Glass effect on the content */
    color: #fff; /* White text for readability */
    font-family: 'Arial', sans-serif;
}

/* Close button (X) */
.close {
    color: #fff;
    font-size: 30px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 15px;
    cursor: pointer;
    transition: color 0.3s ease;
}

/* Close button hover effect */
.close:hover,
.close:focus {
    color: #ff4081; /* Highlight color when hovering */
    text-decoration: none;
}

/* Header text inside the modal */
.modal h2 {
    font-size: 24px;
    margin-bottom: 20px;
    font-weight: 600;
    color: #fff; /* Ensure the heading is visible */
}

/* Form input and button styling */
.modal input[type="number"],
.modal input[type="text"],
.modal button {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

.modal input[type="number"],
.modal input[type="text"] {
    background: rgba(255, 255, 255, 0.2); /* Slightly transparent background for inputs */
    color: #fff; /* White text */
    border: 1px solid rgba(255, 255, 255, 0.4); /* Subtle border */
}

.modal button {
    background: #ff4081; /* Attractive pink button */
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Button hover effect */
.modal button:hover {
    background: #f50057; /* Darker pink when hovered */
}

/* Button Styling */
.toggle-button {
    margin-left: 50%;
    transform: translateX(-50%);
    padding: 10px 20px;
    font-size: 16px;
    font-weight: bold;
    background-color: #f9f9f9; /* Light background for a soft look */
    color: #4b137d; /* Dark purple text color */
    border: 2px solid #4b137d; /* Matching border for consistency */
    border-radius: 8px; /* Softer rounded corners */
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
}

input[type="date"] {    
    padding: 12px;
    margin: 7px 0;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

input[type="date"] {
    background: rgba(255, 255, 255, 0.2); /* Slightly transparent background for inputs */
    color: #fff; /* White text */
    border: 1px solid rgba(255, 255, 255, 0.4); /* Subtle border */
}
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1) grayscale(1) brightness(0.8); /* Adjust the icon color */
}
@media (max-width: 768px) {
    input[type="date"] {    
    width: 100%;
}
}  

.menu-item {
    display: flex; /* Align items horizontally */
    align-items: flex-start; /* Align at the top */
    background: #222;
    
    
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.4);
}

/* Style for the image */
.menu-image {
    width: 75px;  /* Adjust image size */
    height: auto;
    border-radius: 8px;
    margin-right: 15px; 
     /* Space between image and text */
}

/* Text content container */
.menu-details {
    display: flex;
    flex-direction: column; /* Stack title and content vertically */
    justify-content: flex-start;
    color: #fff;
}

/* Title (h3) styling */
.menu-details h3 {
    margin: 0;
    font-size: 1.5em;
     /* Space between title and description */
}

/* Description (p) styling */
.menu-details p {
    margin: 0;
    color: #ccc;
    font-size: 0.9em;
    font-style: italic;
}

/* Price (span) styling */
.menu-details .price {
    margin-top: 20px;
    margin-left: 1px;
    font-weight: bold;
    color:rgba(146, 146, 146, 0.73); /* Green color for price */
}

.price span{
    font-style: italic;
    font-size: smaller;
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
          <h2>Cuba Libre</h2>
          <ol>
            <li><a href="../index.php">Party M</a></li>
            <li><a href="../klubovi.php">Klubovi</a></li>
            <li>Cuba Libre</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <main id="main">

<div class="club-page">
    <!-- Header with image and details -->
    <div class="club-header">
        <div class="header-image">
            <img src="../assets/img/klubs.jpg" alt="Cuba Libre Night Club">
        </div>
        <div class="club-details">
            <h1>Cuba Libre</h1>
            <p class="specialties">Night Club | Affordable Drinks</p>
            <p>Klub koji pretvara deluziju u realnost. Ludnica svake večeri!</p>
            <div class="star-divider">
                <span class="stars">
                    ★★★★
                </span>
                <span class="rating">(4/5)</span>
            </div>
        </div>
    </div>


<div class="reservation-section">
<button class="toggle-button" onclick="toggleTableContainer()">Rezerviši ovde</button>

<input type="date" id="dateInput">

<script>
    document.addEventListener("DOMContentLoaded", function() {
    // Get the current date
    const today = new Date();
    
    // Format the date in YYYY-MM-DD format
    const formattedDate = today.toISOString().split('T')[0];
    
    // Get the input element by its id (change 'dateInput' to your input's id)
    const dateInput = document.getElementById('dateInput');
    
    // Set the input's value to today's date
    dateInput.value = formattedDate;
});
</script>

<div class="reservation-container">
    <!-- Table Selection -->
    <div class="table-container" style="margin-top:10px;">
        <img src="../assets/img/tocionica/tocionicaunutra.jpg" alt="Restaurant Layout" width="100%;">
        <div class="table table1" onclick="selectTable(1)">1</div>
        <div class="table table2" onclick="selectTable(2)">2</div>
        <div class="table table3" onclick="selectTable(3)">3</div>
        <div class="table table4" onclick="selectTable(4)">4</div>
    </div>

    <!-- Reservation form (initially hidden) -->
    <div id="reservation-modal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Rezervacija Stola</h2>
        <form action="submit_reservation.php" method="POST">
            <input type="hidden" name="table" id="table-number">
            <p id="selected-table">Odabrani Sto</p>
            <label for="people">Broj Ljudi</label>
            <input type="number" name="people" id="people" required min="1" max="20">
            <br>
            <label for="name">Komentar</label>
            <input type="text" name="name" id="name" required>
            <br>
            <button type="submit">Reserve</button>
        </form>
    </div>
</div></div>
    </div>

<script>
    // Function to open the modal and set the selected table number
    function selectTable(tableNumber) {
        document.getElementById('table-number').value = tableNumber;
        document.getElementById('selected-table').textContent = 'Selected Table: ' + tableNumber;
        document.getElementById('reservation-modal').style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('reservation-modal').style.display = 'none';
    }
</script>
<script>
function toggleTableContainer() {
    var tableContainer = document.querySelector('.table-container');
    // Toggle between 'none' and 'block'
    tableContainer.style.display = (tableContainer.style.display === "none" || tableContainer.style.display === "") ? "block" : "none";
}
</script>


    


    <!-- DJ Lineup Section -->
    <div class="dj-lineup-section">
        <h2 class="h2">DJ Lineup</h2>
        <div class="dj-item">
    <img src="../assets/img/djj.jpg" alt="DJ Marko Beats">
    <div>
        <h3>Zaun</h3>
        <p>House & Techno Vibes</p>
        <span class="set-time">Petak: 22:00 - 02:00</span>
    </div>
</div>
<div class="dj-item">
    <img src="../assets/img/djjj.png" alt="DJ Ana Groove">
    <div>
        <h3>Araxys</h3>
        <p>R&B and Hip-Hop Hits</p>
        <span class="set-time">Subota: 23:00 - 03:00</span>
    </div>
</div>
<div class="dj-item">
    <img src="../assets/img/klubs.jpg" alt="DJ Luka Vibes">
    <div>
        <h3>F34R</h3>
        <p>Reggaeton & Latino Mix</p>
        <span class="set-time">Nedelja: 21:00 - 01:00</span>
    </div>
</div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="events-section">
        <h2 class="h2">Predstojeći Događaji</h2>
        <div class="event-item">
            <h3>Glow Night Party</h3>
            <p>Specijalni efekti i fluorescentna pića!</p>
            <span class="event-date">28. Oktobar | 22:00</span>
        </div>
        <div class="event-item">
            <h3>Retro 90's Night</h3>
            <p>Vratite se u vreme najvećih hitova 90-ih!</p>
            <span class="event-date">4. Novembar | 21:00</span>
        </div>
    </div>

    <!-- Drinks Menu Section -->
    <div class="drinks-menu-section">
        <h2 class="h2">Naša Pića</h2>

        <div class="menu-item">
            <img src="../assets/img/pice3" alt="Cuba Libre" class="menu-image">
            <div class="menu-details">
                <h3>Cuba Libre</h3>
                <p>Rum, Coca-Cola, limeta</p>
                <span class="price">500 <span>rsd.</span></span>
            </div>
        </div>

        <div class="menu-item">
            <img src="../assets/img/pice1" alt="Cuba Libre" class="menu-image">
            <div class="menu-details">
            <h3>Mojito</h3>
            <p>Rum, šećer, limeta, soda, nana</p>
            <span class="price">600 <span>rsd.</span></span>
            </div>
        </div>
        <div class="menu-item">
        <img src="../assets/img/pice4" alt="Cuba Libre" class="menu-image">
            <div class="menu-details">
                <h3>Chica</h3>
                <p>Signature cocktail</p>
                <span class="price">350 <span>rsd.</span></span>
            </div>
        </div>

        <div class="menu-item">
            <img src="../assets/img/pice5" alt="Cuba Libre" class="menu-image">
            <div class="menu-details">
            <h3>Mojito</h3>
            <p>Rum, šećer, limeta, soda, nana</p>
            <span class="price">600 <span>rsd.</span></span>
            </div>
        </div>
    </div>

    <!-- Opening Hours & Location -->
    <div class="info-section">
        <h2 class="h2">Radno Vreme</h2>
        <p>Ponedeljak - Nedelja: 20:00 - 03:00</p>
        <h2>Lokacija</h2>
        <p>Bulevar Oslobođenja 34, Novi Sad</p>
    </div>

    <!-- Customer Reviews -->
    <div class="reviews-section">
        <h2 class="h2">Recenzije</h2>
        <div class="review">
            <p><strong>Marko P.</strong>: "Najbolja muzika i atmosfera u gradu!"</p>
        </div>
        <div class="review">
            <p><strong>Jovana M.</strong>: "DJ Ana je razvalila! Pića su bila super povoljna."</p>
        </div>
    </div>
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