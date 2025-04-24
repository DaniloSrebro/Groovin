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




$conn->close();

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

  <title>Party M</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="./assets/img/logo2.png" rel="icon">
  <link href="./assets/img/logo2.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Brygada+1918:ital,wght@0,400..700;1,400..700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    .carousel-item {
    position: relative;
    height: 100vh; /* Full-height carousel */
    display: flex;
    align-items: center;
    justify-content: center;
}

.carousel-container {
    position: relative;
    z-index: 2; /* Make sure content is on top */
    text-align: center;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    padding: 20px;
     /* Rounded corners */
}

.button-container {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 20px; /* Space between buttons */
}

.btn-get-started {
    background-color: #ff6f61; /* Button color */
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.btn-get-started:hover {
    background-color: #ff4f4f; /* Darker shade on hover */
}

.search-wrapper {
    display: flex;
    align-items: center;
}

.search-box {
    display: flex;
    align-items: center;
    background-color: #fff;
    border-radius: 5px;
    padding: 5px;
}

.search-box input {
    border: none;
    outline: none;
}

.location-select-wrapper {
    display: flex;
    align-items: center;
    margin-left: 10px;
}

/* Media query to hide the button on smaller screens */

    body{
      height: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
            background: linear-gradient(to bottom, #f0f0f0, #ffffff);
    background-position: center;
    background-size: cover;
    background-attachment: fixed;
            font-family: "Poppins", sans-serif;
            font-style: italic;
        }


        

        .logo{
          text-transform: uppercase;
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
.search-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
}
@media (max-width: 800px) {
  .search-wrapper {
    padding: 10px;
  }
  
  
}



.search-box {
  display: flex;
  gap: 10px;
  margin-bottom: 0px;
  align-items: center;
}

#search-input, .location-select-wrapper select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
}

#search-input:focus, .location-select-wrapper select:focus {
  outline: none;
  border-color: #007bff;
}

.location-select-wrapper {
  display: flex;
  align-items: center;
  gap: 5px;
}

.bi-geo {
  font-size: 20px;
  color: white; /* Adjust the size of the geo icon as needed */
}
.bi-shop {
  font-size: 20px;
  color: white; /* Adjust the size of the geo icon as needed */
}





#search-results {
  font-family: "PT Sans", sans-serif;
    position: absolute;
    top: calc(100% - 10px); /* Add some space between the input and results */
    left: 50%;
    transform: translateX(-50%);
    background: white;
    width: 400px;
    border: 1px solid #ccc;
    display: none;
    z-index: 1000;
    border-radius: 50px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    overflow-y: auto; /* Add scrollbar when content overflows vertically */
    max-height: 300px;
     /* Limit max height of the container to avoid excessive scrolling */
    align-items: center;
    justify-content: center;
    text-align: center;
}

#search-results a {
    display: inline-flex;                  /* Align items inline and center vertically */
    align-items: center;                  /* Center align items vertically */
    justify-content: center;              /* Center align items horizontally */
    text-align: center;                   /* Center text within the link */
    padding: 12px 24px;                   /* Comfortable padding for a better touch target */
    width: 100%;                          /* Full width */
    color: black;                         /* Text color for contrast */
    text-decoration: none;                /* Remove underline from links */
    border-radius: 50px;                 /* Fully rounded corners for a pill shape */
    background: white; /* Gradient background */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Deeper shadow for modern depth */
    font-weight: bold;                   /* Bold text for emphasis */
    font-size: 16px;                     /* Larger font size for readability */
    transition: background 0.5s ease;    /* Smooth transition for background color */
}

#search-results a:hover {
    background: paleturquoise; /* Inverted gradient on hover */
    cursor: pointer;                     /* Change cursor to pointer on hover */
}

#search-results a:active {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Original shadow when active */
}
#search-results img {
    max-width: 80px; /* Adjust the maximum width as needed */
    max-height: 80px; /* Adjust the maximum height as needed */
    margin-left: 97px;
    border-radius: 5px;/* Add margin to the left to separate the image from the text */
}


label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

/* Styles for select box */
select {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  width: 200px; /* Adjust as needed */
}

/* Style for selected option */
option[selected] {
  font-weight: bold;
}

/* Style for options dropdown */
select:focus {
  outline: none;
  box-shadow: 0 0 5px rgba(150, 150, 150, 1);
}







/* Style the select dropdown */
@media only screen and (max-width: 800px) {
          .prvitekst{
            display: none;
          }
          .search-box {
            display: inline;
            gap: 50px;
            margin-top: 20px;
            align-items: center;
          }
          .prvodugme{
            display: none;
          }
          .location-select-wrapper{
            display: none;
          }
          .prvilogo{
            display: none;
          }
          #hero h2 {
            color: #fff;
            margin-bottom: 0px;
            font-size: 38px;
            
  font-weight: 200;
  font-style: normal;
          }
          #header .logo img {
            max-height: 40px;
          }
          
        }

        


.lokacijamaliekran{
  display: none;
}

@media only screen and (max-width: 800px) {
  .lokacijamaliekran{
    margin-top: 30px;
    display: block;
  }
}

.scroll-watcher{
  height: 10px;
  position: fixed;
  top: 0;
  z-index: 10000;
  background-color: #4b137d;
  width: 100%;
  transform-origin: left;
  scale: 0 1;
  animation: scroll-watcher linear;
  animation-timeline: scroll();
}
@keyframes scroll-watcher{
  to{scale: 1 1;}
}

.products * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}.products {
    display: flex;
    justify-content: space-between;
    gap: 25px; /* Increase gap slightly */
    padding: 20px;
    flex-wrap: wrap;
    box-sizing: border-box;
}

.product {
    position: relative;
    width: calc(42% - 20px); /* Increased width for larger images */
    max-width: 400px; /* Adjust max-width */
    overflow: hidden;
    border-radius: 10px;
    margin: auto;
}

.product a {
    display: block;
    text-decoration: none;
    color: inherit;
    position: relative;
    border-radius: 10px;
    overflow: hidden;
}

.product img {
    display: block;
    width: 100%;
    height: auto;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.product a:hover img {
    transform: scale(1.07); /* Slightly larger zoom on hover */
}

.product a::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.35); /* Reduced dimming effect */
    transition: background 0.3s ease;
    pointer-events: none;
    border-radius: 10px;
}

.product a:hover::after {
    background: rgba(0, 0, 0, 0.25); /* Even less dimming on hover */
}

.product h2 {
    position: absolute;
    bottom: 15px;
    left: 15px;
    color: white;
    font-size: 1.7rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    font-weight: bold;
    margin: 0;
    pointer-events: none;
    z-index: 2;
}

.dugme1{
    padding: 10px 20px;
    background-color: #4b137d;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.dugme1:hover {
    background-color: black;
}

.dugme23{
    padding: 10px 20px;
    background-color: grey;
    text-decoration: line-through;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.dugme23:hover {
    background-color: black;
}

.servicename {
    font-family: 'Arial', sans-serif; /* Choose a modern sans-serif font */
    font-size: 1.5rem; /* Adjust the font size for prominence */
    font-weight: 600; /* Use a semi-bold weight for emphasis */
    color: #333; /* Dark gray color for better readability */
    margin: 1rem 0; /* Add some vertical space around the heading */
    text-align: center; /* Center the text for a clean look */
    text-transform: uppercase; /* Uppercase for a modern touch */
    letter-spacing: 1px; /* Slightly increase the letter spacing */
}

/* Optional: Add a subtle bottom border for separation */
.servicename::after {
    content: "";
    display: block;
    width: 50px; /* Width of the border */
    height: 2px; /* Height of the border */
    background-color: #ccc; /* Light gray for a minimal look */
    margin: 0.5rem auto; /* Center it below the text */
}




/* Responsive Design */
@media (max-width: 768px) {
    .products {
        flex-direction: column;
        align-items: center;
    }

    .product {
        width: 90%;
        margin-bottom: 20px;
    }
}
  </style>
  

  



</head>


<body>
  <div id="preloader">
  
  </div>

  <div class="scroll-watcher"></div>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <!-- <h1 class="logo" style="text-transform: none"><a href="index.html">Party M</a></h1> -->
      <a href="index.html" class="logo"><img src="./assets/img/logo3.png" alt="" class="img-fluid"></a>
      
      

      <nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link scrollto active" href="#hero">Početna</a></li>
         
          
          
        
          
         
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

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

        

        <div class="carousel-inner" role="listbox">

          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url(./assets/img/indexx.jpg); background-size: cover; background-position: center;">
    <div class="carousel-container">
        <div class="carousel-content">
            <h2 class="animate__animated animate__fadeInDown" style="font-size: 40px; color: #fff; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Party M</h2>
            <p class="animate__animated animate__fadeInUp" style="font-size: 20px; color: #fff; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);">"Rezerviši svoj provod"</p>
            <a href="#main" class="btn-get-started animate__animated animate__fadeInUp scrollto">Saznaj Više</a>
            <div class="button-container">
            
                <div class="search-wrapper animate__animated animate__fadeInUp scrollto">
                    <div class="search-box">
                        <i class="bi bi-shop"></i>
                        <input type="text" id="search-input" placeholder="Pretraži lokal..." style="border: none; border-radius: 5px; padding: 10px; width: 250px;">
                        <div class="location-select-wrapper">
                            <i class="bi bi-geo"></i>
                            <select id="location-select" style="border: none; border-radius: 5px; padding: 10px; background-color: #fff;">
                                <option value="Novi Sad">Novi Sad</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="search-results"></div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
                  
              </div>
            </div>
            
          </div>   
          
  </section>

    
  


  

  




  <main id="main">
<br>
  <h4 class="servicename">Lokali</h4>
  

<section class="products" id="products">
    <div class="product">
        <a href="./restoranikafici.php">
            <img src="./assets/img/restorants.jpg" alt="Restorani/Kafići">
            <h2>Restorani/Kafići</h2>
        </a>
    </div>
    <div class="product">
        <a href="./klubovi.php">
            <img src="./assets/img/klubs.jpg" alt="Klubovi">
            <h2>Klubovi</h2>
        </a>
    </div>
    <div class="product">
        <a href="#trending">
            <img src="./assets/img/trending.jpg" alt="Trending">
            <h2>Trending</h2>
        </a>
    </div>
</section>

<h4 class="servicename">HotCue</h4>
<section class="products" id="products">
    <div class="product">
        <a href="#beats">
            <img src="./assets/img/beat.jpg" alt="Beats & Reviews">
            <h2>Beats & Reviews</h2>
        </a>
    </div>
  
    <div class="product">
        <a href="./dj.php">
            <img src="./assets/img/djservis.jpg" alt="Mixer">
            <h2>Mixer</h2>
        </a>
    </div>
  
    <div class="product">
        <a href="#equipment">
            <img src="./assets/img/zvucnik.jpg" alt="Oprema & Ozvučenje">
            <h2>Oprema & Ozvučenje</h2>
        </a>
    </div>
</section>

    
    
    
    

    <section id="about" class="about">
      <div class="container">

        <div class="row no-gutters" style="color: #f8f8f8">
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start"></div>
          <div class="col-xl-7 ps-0 ps-lg-5 pe-lg-1 d-flex align-items-stretch">
            <div class="content d-flex flex-column justify-content-center">
              <h3>Naša Priča</h3>
              <p>
              Dobro došli u srce naše strasti - Party M, gde svaka rezervacija otkriva više od samo stola za večeru, ona otvara vrata nezaboravnim iskustvima i stvara uspomene koje traju. Naša avantura započela je 2024, kada smo, kao grupa prijatelja zaljubljenika u kulinarstvo i noćni život, shvatili koliko može biti teško pronaći savršeno mesto za večeru ili veče u gradu. Iz te jednostavne, ali duboke potrebe, rodila se ideja: stvoriti platformu koja bi omogućila svakome da lako pronađe i rezerviše idealno mesto za svaku priliku.
              </p>
              <div class="row">
                <div class="col-md-6 icon-box">
                  <i class="bx bx-receipt"></i>
                  <h4>Korisničko iskustvo</h4>
                  <p>Strastveno se trudimo da svakom korisniku pružimo nezaboravno iskustvo, počevši od trenutka kada posete našu platformu.</p>
                </div>
                <div class="col-md-6 icon-box">
                  <i class="bx bx-cube-alt"></i>
                  <h4>Inovacija</h4>
                  <p>Neprestano se razvijamo i unapređujemo našu platformu kako bismo pružili najnovije i najbolje moguće usluge.</p>
                </div>
                <div class="col-md-6 icon-box">
                <i class="bi bi-share-fill"></i>
                  <h4>Povezivanje</h4>
                  <p>Naša misija je da povežemo ljude sa nezaboravnim iskustvima, bilo da je u pitanju večera u restoranu ili noć u klubu, stvarajući veze koje traju.</p>
                </div>
                <div class="col-md-6 icon-box">
                  <i class="bx bx-shield"></i>
                  <h4>Pouzdanost</h4>
                  <p>Gradimo poverenje kroz doslednost i tačnost u svakoj rezervaciji koju naši korisnici naprave putem naše platforme.</p>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

  


<br>

    


    <section id="faq" class="faq section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Često Postavljena pitanja</h2>
          <p>Sekcija Često Postavljanih Pitanja, poznata kao FAQ, je zbirka informacija organizovana u obliku pitanja i odgovora, namenjena da pruži brze odgovore na uobičajena pitanja korisnika ili posetilaca.</p>
        </div>

        <div class="faq-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">Da li moram biti ulogovan/a da bih mogao poslati rezervaciju? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                <p>
                  Ne morate,  Party M nudi dve vrste rezervacija, jednu preko našeg vebsajta (gde morate biti ulogovani), a druga opcija je preko vidžeta koji možete pronaći na vebsajtu svog lokala ili u Google opisu lokala pod nazivom - Book a Table.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">Zašto je bolje rezervisati preko Party M vebsajta? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                <p>
                Naša usluga omogućava brže rezervacije tako što Vam, nakon registracije, daje mogućnost da odaberete vrstu stola koju želite, bez potrebe za unošenjem ličnih podataka poput email adrese i imena za rezervaciju.
                </p>
              </div>
            </li>
            
            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">Kako dobijam potvrdu o rezervaciji ukoliko rezervišem putem vebsajta? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                <p>
                Nakon što pošaljete svoju rezervaciju, bićete automatski preusmereni na Vašu profilnu stranicu, gde ćete moći da pratite status Vaše rezervacije (odobrena, u obradi, odbijena). Takođe, na Vašu email adresu će stići obaveštenje o potvrđenoj rezervaciji. Prilikom registracije, neophodno je da ostavite važeću email adresu, kako bismo mogli uspešno da obradimo Vaš zahtev.
                </p>
              </div>
            </li>
            
            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">Kako dobijam potvrdu o rezervaciji ukoliko rezervišem putem vidžeta? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                <p>
                Ukoliko rezervaciju pošaljete putem vidžeta, potvrdu o rezervaciji ćete primiti na Vašu email adresu. Iz tog razloga je bitno da date važeću adresu tokom rezervacije.
                </p>
              </div>
            </li>


            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">Koliko čekam potvrdu o rezervaciji? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                <p>
                U svakom lokalu nalazi se sistem za rezervacije, te odmah nakon što osoblje odredi sto na kom ćete biti smešteni, Vi ćete primiti potvrdu o rezervaciji. Ovaj proces bi, uobičajeno, trebalo da traje između 5 i 10 minuta.
                </p>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->

    

    

    
    


    
    

    
    <br><br> <br><br> 


    
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title" style="color: #f8f8f8">
          <h2 >Kontakt</h2>
          <p >Ako imate bilo kakvih pitanja, ideja o proširivanju stranice, primećenih bagova, samo napišite.</p><br>
          <p >Potrudićemo se da Vam odgovorimo u najkraćem roku! :D</p>
        </div>

        <div class="row contact-info">

          <div class="col-md-4">
            <div class="contact-address">
              
              
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-email">
              <i class="bi bi-envelope" style="color: white;"></i>
              <h3 style="color: #f8f8f8; font-size:35px;">info@partym.rs</h3>
              <h3 style="color: gray; font-size:20px;">ili nas kontaktirajte putem vebsajta</h3>
              <p style="color: black">u sledecoj formi</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-phone">
              
            </div>
          </div>
</div>

        <div class="form">
          <form action="./assets/admin/posaljiideju.php" method="post" role="form" class="php-email-form">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Ime" data-rule="minlen:4" data-msg="Please enter at least 4 chars">
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Please enter a valid email">
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Tema" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" rows="5" placeholder="Poruka" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Poruka je poslata. Hvala Vam!</div>
            </div>
            <div class="text-center"><button type="submit">Posalji poruku</button></div>
          </form>
        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->
  <a href="https://www.freepik.com/free-vector/white-background-with-hexagonal-line-pattern-design_10837496.htm#fromView=search&page=2&position=16&uuid=db68fa60-b9f9-4b3f-8cb1-dc1186660d3a">Image by starline on Freepik</a>

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Party M  <img src="./assets/img/logo1.png" alt="" style="width:70px; height:65px;"></h3>
              
              <p>
                <strong>Informacije:</strong> info@partym.rs<br>
                <strong>Saradnja:</strong> partner@partym.rs<br>
              </p>
              
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
    const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');

searchInput.addEventListener('input', function() {
    const query = this.value.trim();

    if (query.length === 0) {
        searchResults.innerHTML = '';
        searchResults.style.display = 'none';
        return;
    }

    fetch(`search.php?q=${query}`)
        .then(response => response.json())
        .then(results => {
            searchResults.innerHTML = '';
            results.forEach(result => {
                const link = document.createElement('a');
                link.href = result.url;

                const resultContainer = document.createElement('div');
                resultContainer.classList.add('search-result');

                const title = document.createElement('span');
                title.textContent = result.title;

                const image = document.createElement('img');
                image.src = result.imageUrl; // Assuming this is the property name holding the image URL
                image.alt = result.title; // Optional: Provide alt text for accessibility

                resultContainer.appendChild(title);
                resultContainer.appendChild(image);
                link.appendChild(resultContainer);

                searchResults.appendChild(link);
            });
            searchResults.style.display = 'block';
        })
        .catch(error => console.error('Error fetching search results:', error));
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
