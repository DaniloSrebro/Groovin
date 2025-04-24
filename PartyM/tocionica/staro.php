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
if ($isLoggedIn) {
    $mysqli = require __DIR__ . "../../forms/database.php";
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (isset($user['email'])) {
            $user_email = $user['email'];
        }
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

  <!-- Google Fonts -->
  
 
 
  
  

 
  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
 
  <link href="../assets//vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets//vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
 

  

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <link href="../assets/css/restoran.css" rel="stylesheet">

 <style>
  /* Keyframes for fading in with a vertical lift */
@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateX(-20px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}





.heading-container {
    display: flex;
    padding-bottom: 10px;
}

.section-heading h2 {
    display: flex;
    flex-wrap: wrap;
    font-family: 'Georgia', serif; /* Elegant font family */
    color: #333; /* Sophisticated color */
    margin-right: 10px; /* Space between heading and stars */
}


/* Star Rating Styles */
.star-rating {
    list-style: none;
    padding: 0;
    display: flex; /* Aligns stars horizontally */
}

.star-rating li {
    display: flex; /* Ensures stars are inline */
}

.star-rating span {
    display: inline-block;
    animation: fadeIn 0.6s ease-out forwards;
    opacity: 0; /* Start with stars hidden */
}

.star-icon {
    font-size: 20px; /* Adjust the size of the stars */
    color: gold; /* Gold color for the stars */
    margin: 0 2px; /* Space between stars */
}

.star-rating span:nth-child(1) { animation-delay: 0.5s; }
.star-rating span:nth-child(2) { animation-delay: 0.6s; }
.star-rating span:nth-child(3) { animation-delay: 0.7s; }
.star-rating span:nth-child(4) { animation-delay: 0.8s; }
.star-rating span:nth-child(5) { animation-delay: 0.9s; }


.heading-container{
  display: flex;
  flex-direction: column;
  padding: 0;
}

#slika{
  width: 250px;
  margin-left: 50%;
  transform: translateX(-50%);
}

.custom-buttons {
    display: none; /* Hide the buttons by default */
}

@media (max-width: 900px) {
    .custom-buttons {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }
    .custom-buttons .col {
        flex: 1; /* Ensure buttons are side by side */
        padding: 5px;
    }
    .custom-buttons .btn-block {
        width: 100%;
        padding: 5px; /* Make sure each button takes up full width of its column */
    }
    .custom-buttons .custom-button.active {
        background-color: #6c757d; /* Darker gray for the active button */
        border-color: #6c757d; /* Darker border */
        color: white; /* Change text color if needed */
    }

    /* Add styles for when the buttons are active or focused */
    .custom-buttons .custom-button:active,
    .custom-buttons .custom-button:focus {
        background-color: #5a6268 !important; /* Darker gray for pressed state */
        border-color: #545b62 !important; /* Optional: darken the border as well */
        outline: none; /* Remove outline on focus */
    }
}


/* Ovde za JS kreiranje */


@media (max-width: 900px) {
  .section2{
  margin-top: -60px;
}

  #radnovreme{
  display: none;
}
  #meni{
  display: none;
}
#rezervacija{
  display: block;
}

#info{
  display: none;
}
#galerija{
  display: none;
}
 
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



    <section class="section" id="reservation">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                  <div class="left-text-content">
                    <div class="section-heading">
                      
                      <div class="heading-container">
                          <h2>
                          <img src="./logotocionica.png" id="slika" alt="" >
                          </h2>
                          
                          
                          
                      </div>
                  </div>
                                             <div class="row custom-buttons">
                                              <div class="col">
                                                  <button onclick="change_inner(1)" class="btn btn-light btn-block custom-button active" aria-pressed="true">Rezerviši</button>
                                              </div>
                                              <div class="col">
                                                  <button onclick="change_inner(2)" class="btn btn-light btn-block custom-button">Meni</button>
                                              </div>
                                              <div class="col">
                                                  <button onclick="change_inner(3)" class="btn btn-light btn-block custom-button">Vreme</button>
                                              </div>
                                              <div class="col">
                                                  <button onclick="change_inner(4)" class="btn btn-light btn-block custom-button">Info</button>
                                              </div>
                                            </div>
                                            
                        <div class="row">
                            <div class="col-lg-6" id="radnovreme">
                                <div class="phone gornji">
                                <i class="bi bi-clock"></i>
                                    <h4>Radno Vreme</h4>
                                    <span id="working-hours">
                                      <span>Ponedeljak: 08:00-23:00</span><br>
                                      <span>Utorak: 08:00-23:00</span><br>
                                      <span>Sreda: 08:00-23:00</span><br>
                                      <span>Četvrtak: 08:00-23:00</span><br>
                                      <span>Petak: 08:00-00:00</span><br>
                                      <span>Subota: 08:00-00:00</span><br>
                                      <span>Nedelja: 09:00-23:00</span><br>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6" id="meni">
                                <div class="message gornji">
                                <i class="bi bi-download"></i>
                                    <h4>Meni</h4>
                                    <span>U prilogu ispod se nalaze <strong>PDF</strong> fajlovi koje mozete skinuti da biste pogledali sadržaj jelovnika i karte pića <br><br><a href="#" target="_blank" style="text-decoration:underline; font-weight: bold;">Jelovnik</a><br><br><a href="./kartapica.pdf" target="_blank" style="text-decoration:underline; font-weight: bold;">Karta Pića</a><br></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" id="rezervacija">
                    <div class="contact-form">
                        <form id="kontakt" action="./process-reservation_tocionica.php" method="post">
                          <div class="row">
                          
                            <div class="col-lg-12">
                                <h4>Rezervacija Stola</h4>
                            </div>
                            
                            <?php if ($error_message): ?>
                                 <p style="color:red;text-align:center;padding:0; margin-bottom:20px;"><?php echo $error_message; ?></p>
                              <?php endif; ?>

                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" maxlength="25" class="form-control" type="text" id="ime" name="ime" placeholder="<?php if (!$isLoggedIn) echo 'Niste ulogovani';else echo'Ime rezervacije' ?>" required >
                              </fieldset>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                              <input onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" maxlength="15" class="form-control" type="text" id="brojtelefona" name="brojtelefona" placeholder="Broj Telefona" required>
                              </fieldset>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                              <select onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" id="mestosedenja" name="mestosedenja" class="form-control">
                              <option>Mesto Sedenja</option>
                              <option>Unutra</option>
												      <option>Bašta</option>
											        </select>
                            </fieldset>
                            </div>


                            <div class="col-md-6 col-sm-12">
                              <fieldset>

                              <select onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" id="brojljudi" name="brojljudi" class="form-control">
                              <option value="number-guests">Broj Gostiju</option>
												<option>1</option>
												<option>2</option>
												<option>3</option>
												<option>4</option>
												<option>5</option>
												<option>6</option>
											</select>
                              </fieldset>
                            </div>
                            <div class="col-lg-6">
                                <div id="filterDate2">    
                                  <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input  onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" class="form-control" id="zadatum" name="zadatum" type="date" required min="<?php echo date('Y-m-d'); ?>" 
                                                                                                   max="<?php echo date('Y-m-d', strtotime('+6 days')); ?>" 
                                                                                                   value="<?php echo date('Y-m-d'); ?>">
                                    <div class="input-group-addon" >
                                      <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                  </div>
                                </div>   
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                              <input onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" class="form-control" type="time" id="vremedolaska" name="vremedolaska" required min="08:00" max="23:59">
                              </fieldset>
                            </div>

                           

                              <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <select onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" id="sedenje" name="sedenje" class="form-control" required>
                                  <option>Vrsta Sedenja</option>
                                  <option>Nisko</option>
												          <option>Visoko</option>
											          </select>
                              </fieldset>
                              </div>

                              <div class="col-lg-6 col-sm-12">
                              <fieldset>
                              <select onclick="proverilogin(<?php if (!$isLoggedIn) echo '1'?>)" id="vrstarez" name="vrstarez" class="form-control" required>
                                  <option>Vrsta Rezervacije</option>
                                  <option>Piće</option>
												          <option>Piće i Hrana</option>
											          </select>
                              </fieldset>
                              </div>

                             
                              <input type="hidden" name="user_email" value="<?php echo htmlspecialchars($user_email);?>">
                              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                              <input type="text" name="honeypott" style="display:none;" value="">

                            
                            <div class="col-lg-12">
                              <fieldset>
                                <button type="submit" id="form-submit" class="main-button-icon" <?php if (!$isLoggedIn) echo 'disabled'; ?>>Napravi Rezervaciju</button>
                              </fieldset>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <section class="section" id="reservation">
        <div class="container section2" id="info">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="left-text-content">
                        <div class="section-heading">
                            
                            
                        </div>
                       
                        
                        <div class="row">
                        <div class="col-lg-6">
                              <div class="phone">
                                <i class="bi bi-pin-map"></i>
                                    <h4>Lokacija</h4>
                                    <span>Adresa: Narodnog Fronta 2, Novi Sad</span><br><br>
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2809.258820938909!2d19.84437227609204!3d45.24255877107125!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475b11566afa63c9%3A0x2febff958a5f3694!2sTO%C4%8CIONICA%20Liman!5e0!3m2!1sen!2srs!4v1710435887060!5m2!1sen!2srs" width="100%" height="200" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    <br><br>
                                    <span>Kontakt telefon: 021/3039-226</span>
                                    </div>    
                            </div>
                            <div class="col-lg-6">
                                <div class="message">
                                <i class="bi bi-info-circle"></i>
                                    <h4>Informacije</h4>
                                      <span>
                                        Ocena: 
                                        <br> 
                                        <a href="https://www.google.com/search?q=tocionica&rlz=1C1ONGR_enRS1073RS1073&oq=&gs_lcrp=EgZjaHJvbWUqCQgAECMYJxjqAjIJCAAQIxgnGOoCMgkIARAjGCcY6gIyCQgCECMYJxjqAjIJCAMQIxgnGOoCMgkIBBAjGCcY6gIyCQgFECMYJxjqAjIJCAYQIxgnGOoCMgkIBxAjGCcY6gLSAQg2MjFqMGoxNagCCLACAQ&sourceid=chrome&ie=UTF-8#lrd=0x475b11566afa63c9:0x2febff958a5f3694,1,,,,"><img src="../assets/img/45zvezde.png" width="100" alt=""><small style="font-style: italic"> - Google Reviews</small></a>
                                        <br><br>
                                        Specijali: 
                                        <br>
                                        "Točionica redovno osvežava jelovnik nedeljnim specijalitetima."<br>
                                        <br>Prosečna cena za dvoje: 
                                        <br>
                                         ~2000 RSD. <br>
                                        <br> Mogućnost plaćanja: <br>
                                         Gotovina/Kartica <br>
                                        <br> Rad kuhinje: <br>
                                        Kuhinja se zatvara sat vremena pre zatvaranja lokala <br>
                                        <br> Parking: <br>
                                         Besplatan parking u okolini lokala <br>
                                        <br> Oficijalni vebsajt: <br>
                                        <a href="https://tocionicapab.com/liman/" style="text-decoration:underline">Точионица Паб</a>
                                        <br>
                                    </span>
                                  </div>
                                </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="col-lg-6">
                    <div class="message spec">
                 
                    <i class="bi bi-star"></i>
                    <h4>Specijal</h4>

                        <div class="specijal">
                          <img src="../assets/img/tocionica/specijal1.jpg" alt="specijal">
                          <br>
                        </div>





                    </div>
                </div>
            </div>
        </div>




        <ul class="star-rating">
                              <li>
                                  <span><i class="bi bi-star-fill star-icon"></i></span>
                                  <span><i class="bi bi-star-fill star-icon"></i></span>
                                  <span><i class="bi bi-star-fill star-icon"></i></span>
                                  <span><i class="bi bi-star-fill star-icon"></i></span>
                                  <span><i class="bi bi-star-half star-icon"></i></span>
                              </li>
                          </ul>















        








       <br><br>                   
           
<div id="galerija">
<div class="message">
<i class="bi bi-images"></i>
<h4>Galerija:</h4>
                <section id="portfolio-details" class="portfolio-details"  >
      <div class="container"  >

        <div class="row gy-4">

          <div class="col-lg-8 offset-lg-2">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/toc4.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/toc3.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/toc6.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/toc7.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/toc9.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/toc11.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/toc15.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/toc17.jpg" alt="">
                </div>

                <div class="swiper-slide">
                  <img src="../assets/img/tocionica/tocburgerslajd.jpg" alt="">
                </div>

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

    </div>
    </div>
                
              









    

    

</main>







<script>
  let radnovreme = document.getElementById("radnovreme");
  let meni = document.getElementById("meni");
  let rezervacija = document.getElementById("rezervacija");
  let info = document.getElementById("info");
  let galerija = document.getElementById("galerija");

  function change_inner(x){
    if(x === 1){
      radnovreme.style.display = "none";
      meni.style.display = "none";
      rezervacija.style.display = "block";
      info.style.display = "none";
      galerija.style.display = "none";
    }
    else if(x === 2){
      radnovreme.style.display = "none";
      meni.style.display = "block";
      rezervacija.style.display = "none";
      info.style.display = "none";
      galerija.style.display = "none";
    }
    else if(x === 3){
      radnovreme.style.display = "block";
      meni.style.display = "none";
      rezervacija.style.display = "none";
      info.style.display = "none";
      galerija.style.display = "none";
    }
    else if(x === 4){
      radnovreme.style.display = "none";
      meni.style.display = "none";
      rezervacija.style.display = "none";
      info.style.display = "block";
      galerija.style.display = "block";
    }
  }
</script>

<script>
    // Get all buttons with the custom-button class
    const buttons = document.querySelectorAll('.custom-button');

    // Add click event listener to each button
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to the clicked button
            button.classList.add('active');
        });
    });
</script>













  




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
  function proverilogin(x){
    if (x == 1){
      alert("Morate biti ulogovani da biste rezervisali.");
      preventDefault();
    }
  }
</script>






  

</body>

</html>