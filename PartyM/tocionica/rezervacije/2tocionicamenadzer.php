<?php
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "rezervacije";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->close();

session_start();

if (!isset($_SESSION['manager_id'])) {
  // Redirect to login page if user is not logged in
  header("Location: ../../formsmenadzer/Login.php");
  exit();
}

if (isset($_SESSION["manager_id"])) {
    
    $mysqli = require __DIR__ . "../../../formsmenadzer/database.php";
    
    $sql = "SELECT * FROM manager
            WHERE id = {$_SESSION["manager_id"]}";
            
    $result = $mysqli->query($sql);
    
    $manager = $result->fetch_assoc();
}

$isLoggedIn = isset($_SESSION["manager_id"]);

// Load manager info if logged in
if ($isLoggedIn) {
    $mysqli = require __DIR__ . "../../../formsmenadzer/database.php";
    $manager_id = $_SESSION["manager_id"];
    $sql = "SELECT * FROM manager WHERE id = $manager_id";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $manager = $result->fetch_assoc();
        
        // Check if email is tocionica@gmail.com
        if ($manager['email'] === 'tocionica@menadzer.com') {
            ?>
            



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Party M - Menadžer</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../assets/img/logopartym.png" rel="icon">
  <link href="../../assets/img/logopartym.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anta&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/" rel="stylesheet">
  <link href="../../assets//vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets//vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">
  <link href="../../assets/css/tocionicamenadzer.css" rel="stylesheet">

  <style>
    body {
      background-color: #141b2d;
  overflow-x: hidden;
}

.reservation-form {
max-width: 600px;
margin: 0 auto;
padding: 10px;
background-color: #f5f5f5 !important;

border-radius: 8px;
box-shadow: 0 2px 4px rgba(0,0,0,0.1);
font-family: Arial, sans-serif;
}

.noverezervacije{
  font-style: normal;
}

.vrstarezervacije{
  font-size: smaller;
}

.button-container {
    display: flex; /* Use flexbox to align buttons horizontally */
    align-items: center; /* Vertically center buttons */
    justify-content: space-evenly;
}

.button-container form {
    margin-right: 10px; /* Space between buttons */
}

@media screen and (max-width: 860px) {
   .button-container{
    display: block;
   }
}
a i {
  color: #9a9a9a;
}
a i:hover {
  color: #fff;
}
.badge-success {
  background-color: #00d68f;
}
.table {
  border-collapse: separate;
  border-spacing: 0 15px;
  color: rgba(255,255,255,0.7);
}
thead tr th {
  border-bottom:0 !important;
  background-color: #192038 !important;
  font-weight: bold !important;
  color: #aab1c1 !important;
}
.table td{
  background-color: #1f2a40 !important;
  color: #bbc0c6;
  font-weight: normal !important;
  
}
.table tr {
  box-shadow: 0 1px 20px 0 rgb(0 0 0 / 10%);
  background-color: #1f2940;
  border-radius:20px;
}

.text-muted{
  color: #6c7480 !important;
}
.table td,
.table th {
  vertical-align: middle;
}
tr td:nth-child(n+5),tr th:nth-child(n+5) {
    border-radius: 0 .625rem .625rem 0;
}
tr td:nth-child(1),tr th:nth-child(1){border-radius: .625rem 0 0 .625rem;}
.table td,
.table th,
.card {
  border: 0;
}
.w-48 {
  width: 3rem;
}
.-ml-5 {
  margin-left: -1.25rem;
}
.h-48 {
  height: 3rem;
}
.thump img {
  height: 100%;
  -o-object-fit: cover;
  object-fit: cover;
  width: 100%;
}






.button1 {
align-items: center;
background-color: transparent;
color: #bbc0c6;
cursor: pointer;
display: flex;
font-family: ui-sans-serif,system-ui,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
font-size: 1rem;
font-weight: 700;
line-height: 1.5;
text-decoration: none;
text-transform: uppercase;
outline: 0;
border: 0;
padding: 1rem;
}
@media (max-width: 768px) {
.button1 {
font-size: 10px; /* Adjust margins */
}
}

.button1:before {
background-color: #bbc0c6;
content: "";
display: inline-block;
height: 1px;
margin-right: 10px;
transition: all .42s cubic-bezier(.25,.8,.25,1);
width: 0;
}

.button1:hover:before {
background-color: #bbc0c6;
width: 3rem;
}

#plus-icon{
  color: #bbc0c6;
}

#reservations {
position: absolute;
    margin-top: -60px;
    padding: 3px;
    background-color: #bbc0c6;
    width: max-content;
    border: 1px solid #ddd;
    color: black;
    border-radius: 20px;
    box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset;
    text-align: center;
}
#reservations i {
  font-size: 25px;
}
  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      
      <h1 class="logo" style="color:white">Party M Menadžer</h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

    

      <nav id="navbar" class="navbar">
        <ul>
          
        <li><a class="nav-link" href="../pregled/pregledtocionica.php">Pregled</a></li> 
        <li><a class="nav-link active" href="#">Rezervacije</a></li> 
        
        <li class="dropdown" id="rez"><a href="#"><span>Istorija</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
            <li><a class="nav-link" href="../istorija/potvrdjenerez.php">Potvrdjene Rezervacije</a></li>
           <li><a class="nav-link" href="../istorija/nepotvrdjenerez.php">Nepotvrđene Rezervacije</a></li>
           <li><a class="nav-link" href="../istorija/odbijenerez.php" style="background-color:red">Odbijene Rezervacije</a></li>
              
            </ul>
          </li>
          
          
          
          <?php if($isLoggedIn): ?>
            <li><a class="getstartedout scrollto" href="../../formsmenadzer/logout.php">Logout</a></li>
          <?php else: ?>
            <li><a class="getstarted scrollto" href="../../formsmenadzer/Login.php">Login</a></li>
        <?php endif; ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      

    </div>
  </header><!-- End Header -->

  <main id="main">

  

  <br>
  <br>
  <br>
  



    <div class="container2">
    <a href="./tocionicamenadzer.php"><button class="button1" id="todayBtn">Today</button>
    <a href="./1tocionicamenadzer.php"><button class="button1" id="tomorrowBtn">Tomorrow</button></a>
    <a href="#"><button class="button1" id="dayAfterTomorrowBtn" style="background-color: rgba(133, 131, 131, 0.5); border: 2px solid #ccc; color: white; border-radius: 20px; cursor: pointer;">Day after Tomorrow</button></a>
    <a href="./3tocionicamenadzer.php"><button class="button1" id="day3Btn">In 3 Days</button></a>
    <a href="./4tocionicamenadzer.php"><button class="button1" id="day4Btn">In 4 Days</button></a>
    <a href="./5tocionicamenadzer.php"><button class="button1" id="day5Btn">In 5 Days</button></a>
    <a href="./6tocionicamenadzer.php"><button class="button1" id="day6Btn">In 6 Days</button></a>
      
    </div>
    




<div class="containersve">
  <div class="item">
      <div class="icon-container">
        <i class="bi bi-plus-circle" id="plus-icon"></i>
      </div>
      <div id="reservations"><i class="bi bi-filter-left"></i></div>
             <!-- Popup forma za rezervacije preko poziva -->
      <form action="../PRMenadzer.php" method="post" class="reservation-form" id="popup-form" style="display: none; padding: 20px; background-color: #f0f0f0;">
        
        <div class="form-group">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="brojljudi">Ukupan broj ljudi:</label>
            <input type="number" id="brojljudi" name="brojljudi" class="form-control">
        </div>

        <div class="form-group">
            <label for="vremedolaska">Vreme Dolaska:</label>
            <input type="time" id="vremedolaska" name="vremedolaska" class="form-control" required>
        </div>
      
        <div class="form-group">
            <label for="zadatum">Datum:</label>
            <input type="date" id="zadatum" name="zadatum" class="form-control">
        </div>

                  <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                        <div class="form-group">
                          <label>Odaberite opciju:</label>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="vrstarez" id="option1" value="Piće">
                              <label class="form-check-label" for="option1">
                                  Piće
                              </label>
                              </div>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="vrstarez" id="option2" value="Piće i Hrana">
                              <label class="form-check-label" for="option2">
                                  Piće i Hrana
                              </label>
                          </div>
                        </div>
                      </div>

      
                      <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                        <div class="form-group">
                        <span class="form-label">
                          <label for="mestosedenja">Mesto Sedenja:</label></span>
                            <select id="mestosedenja" name="mestosedenja" class="form-control">
                              <option selected>Unutra</option>
                              <option>Bašta</option>
                            </select>
                            <span class="select-arrow"></span>
                          </div>
                      </div>

                      <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                        <div class="form-group">
                          <label for="sedenje">Sedenje:</label>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="sedenje" id="option1" value="nisko">
                              <label class="form-check-label" for="option1">
                                  Nisko
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="sedenje" id="option2" value="visoko">
                              <label class="form-check-label" for="option2">
                                  Visoko
                              </label>
                            </div>
                        </div>
                      </div>

                  </div>

        <div class="form-group">
            <label for="brojtelefona">Broj Telefona:</label>
            <input type="tel" id="brojtelefona" name="brojtelefona" class="form-control">
        </div>

        <div class="form-group">
        <label for='inputFieldd'>Dodeli Sto:</label>
         <input type='text' id='inputFieldd' name='inputFieldd' class="form-control">
         </div>

        <button class="subdugme" type="submit">Dodaj</button>
    </form>
      
    <?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "Sinke008"; // Replace with your MySQL password
$database1 = "rezervacije"; // Replace with your first database name

// Database connection details for the second database (users)
$database2 = "login_db"; // Replace with your second database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database1);

// Check connection
if ($conn->connect_error) {
    die("Connection to 'rezervacije' failed: " . $conn->connect_error);
}

$default_image = 'https://bootdey.com/img/Content/avatar/avatar7.png';

// SQL query to retrieve reservations
$sql_select = "SELECT t.id, t.Ime, t.brojtelefona, t.brojstola, t.vrstarez, t.brojljudi, t.reservationstatus, t.zadatum, t.vremedolaska, t.vremerez, t.mestosedenja, t.sedenje, u.profile_pic_url, u.email FROM rezervacije.tocionica t LEFT JOIN login_db.user u ON t.id = u.id WHERE t.zadatum = DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND t.reservationstatus = 'pending' ORDER BY t.vremerez ASC";


$result = $conn->query($sql_select);

// Check if there are results
if ($result->num_rows > 0) {
  echo "<div class='noverezervacije'>";
  echo "<div class='h-auto row align-items-center'>";
  echo "<div class='container'>";
  echo "<div class='col-lg-12 col-12'>
        <div class='card bg-transparent'>
          <div class='table-responsive'>
            <table class='table'>";
  echo "<thead>
                <tr>
                  <th>Info</th>
                  <th>Dolazak</th>
                  <th>Broj</th>
                  <th>Vrsta</th>
                  <th>Akcije</th>
                </tr>
              </thead>";


      echo "<tbody>";

      while ($row = $result->fetch_assoc()) {
        $time = new DateTime($row['vremedolaska']);
          echo "      <tr>
                  <td>
                    <div class='d-flex align-items-center'>
                      <div class='w-48 h-48 thump'> ";
                       echo " <img class='rounded-circle img-fluid' src='" . ($row['profile_pic_url'] ? '../../' . $row['profile_pic_url'] : $default_image) . "' alt='PartyM'>
                      </div> ";
                      echo "<div class='ml-3'>";
                       echo " <div class=''>" . $row["Ime"] . "</div> ";
                       echo " <div class='text-muted'>" . $row["email"] . "</div>";
                      echo "</div>
                    </div>
                  </td>";
                  echo "<td>
            <div>" . $time->format('H:i') . "</div>
          </td>";
                  echo" <td class=''>
                    " . $row["brojljudi"] . "
                  </td>";
                  echo "<td class='vrstarezervacije'>
        " . $row["mestosedenja"] . "<br>" 
        . $row["sedenje"] . "<br>" 
        . $row["vrstarez"] . "
      </td>";
                  echo "
        <td>
            <div class='button-container'>
                <div class='containerodbi'>
        <button onclick='ukljuciForm(this)' class='reject-button'><i class='bi bi-ban'></i></button>
          <div class='form-container-odbi' style='display: none;'>
              <form method='post' action='../akcije/odbij/2odbij.php'>
                <input type='hidden' name='reservation_id' value='" . $row["id"] . "'>
                <button type='submit' class='reject-button'><i class='bi bi-check2'></i></button>
              </form>
          </div>
      </div>
                <div class='containersmesti'>
                    <button onclick='toggleForm(this)' class='approve-button'><i class='bi bi-check2-square'></i></button>
                    <div class='form-container' style='display: none;'>
                        <form method='post' action='../akcije/odobri/2odobri.php'>
                            <input type='hidden' name='reservation_id' value='" . $row["id"] . "'>
                            <label for='inputField'>Sto:</label>
                            <input type='text' id='inputField' name='inputField'>
                            <button type='submit' class='dodajsto'>Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </td>
      ";
           echo "     </tr>";
      }
      echo "
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>"; 
      
  echo "</div>"; // Close reservation-container div

} else {
  echo "<p class='no-reservation' style='color:#bbc0c6;'>Nema trenutnih rezervacija.</p>";
  echo "</div>";
}

// Close connection
$conn->close();

?> 


<div class="item">
<div class="col">
        <div class="container1" id="div1">
          <img src="../../assets/img/tocionica/tocionicaunutra.jpg" alt="Your Image">
          <button class="btn" id="btn1" data-table="1">1</button>
          <button class="btn" id="btn2" data-table="2">2</button>
          <button class="btn" id="btn3" data-table="3">3</button>
          <button class="btn" id="btn4" data-table="4">4</button>
          <button class="btn" id="btn5" data-table="5">5</button>
          <button class="btn" id="btn6" data-table="6">6</button>
          <button class="btn" id="btn7" data-table="7">7</button>
          <button class="btn" id="btn8" data-table="8">8</button>
          <button class="btn" id="btn9" data-table="9">9</button>

          <button class="btn" id="btn10" data-table="10">10</button>
          <button class="btn" id="btn11" data-table="11">11</button>
          <button class="btn" id="btn12" data-table="12">12</button>
          <button class="btn" id="btn13" data-table="13">13</button>
          <button class="btn" id="btn14" data-table="14">14</button>
          <button class="btn" id="btn15" data-table="15">15</button>
          <button class="btn" id="btn16" data-table="16">16</button>
          <button class="btn" id="btn17" data-table="17">17</button>

          <button class="btn" id="btn18" data-table="18">18</button>
          <button class="btn" id="btn19" data-table="19">19</button>
          <button class="btn" id="btn20" data-table="20">20</button>
          <button class="btn" id="btn21" data-table="21">21</button>
          <button class="btn" id="btn22" data-table="22">22</button>  
          
          <button onclick="toggleDivs()" id="myButton">Predji u bastu</button>
      </div>
      
      <div class="container1 hidden" id="div2">
      <img src="../../assets/img/tocionica/tocionicabasta.jpg" alt="Your Image">
      <button class="btn" id="btn23" data-table="23">23</button>
          <button class="btn" id="btn24" data-table="24">24</button>
          <button class="btn" id="btn25" data-table="25">25</button>

          <button class="btn" id="btn26" data-table="26">26</button>
          <button class="btn" id="btn27" data-table="27">27</button>
          <button class="btn" id="btn28" data-table="28">28</button> 

          <button class="btn" id="btn29" data-table="29">29</button>
          <button class="btn" id="btn30" data-table="30">30</button>
          <button class="btn" id="btn31" data-table="31">31</button>
          
          <button class="btn" id="btn32" data-table="32">32</button>
          <button class="btn" id="btn33" data-table="33">33</button>
          <button class="btn" id="btn34" data-table="34">34</button>

          <button class="btn" id="btn35" data-table="35">35</button>
          <button class="btn" id="btn36" data-table="36">36</button>
          <button class="btn" id="btn37" data-table="37">37</button>

          <button class="btn" id="btn38" data-table="38">38</button>
          <button class="btn" id="btn39" data-table="39">39</button>
          <button class="btn" id="btn40" data-table="40">40</button>

    <button onclick="toggleDivs()" id="myButton">Vrati se Unutra</button>
          </div>
          
      </div>
      </div>
    </div>


    <table class="tabelarezervacija">
    <tr>
        <th>Broj Stola</th>
        <th>Vreme Rezervacije</th>
    </tr>
    <?php
        // Establishing connection to the database          //Ispisivanje vec napravljenih rezervacija za taj dan
        $servername = "localhost";
        $username = "root";
        $password = "Sinke008";
        $dbname = "rezervacije";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Checking connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieving data from the database
        $sql = "SELECT brojstola, vremedolaska FROM tocionica WHERE reservationstatus='approved' AND zadatum = DATE_ADD(CURDATE(), INTERVAL 2 DAY) ORDER BY vremedolaska asc";
        $result = $conn->query($sql);

        // Displaying data in table rows
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["brojstola"] . "</td><td>" . $row["vremedolaska"] . "</td></tr>";
            }
        } else {
            echo "";
        }

        // Closing connection
        $conn->close();
    ?>
</table>





<br><br><br><br><br><br><br><br><br><br><br>

    

  <!-- ======= Footer ======= -->
  <footer id="footer">
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
  <script src="../../assets/"></script>
  <script src="../../assets//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets//vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../assets//vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../assets//vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../assets//vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets//js/main.js"></script>

  <script>
// Set the idle time limit in milliseconds
const IDLE_TIMEOUT = 20000; // 20 seconds

let idleTimer;

function resetIdleTimer() {
    clearTimeout(idleTimer);
    idleTimer = setTimeout(redirectUser, IDLE_TIMEOUT);
}

function redirectUser() {
    // Redirect the user to another page
    window.location.href = '../pregled/pregledtocionica.php';
}

// Add event listeners for mousemove and click events to reset the idle timer
document.addEventListener('mousemove', resetIdleTimer);
document.addEventListener('click', resetIdleTimer);

// Start the idle timer initially
resetIdleTimer();
</script>

  <script>
  // Select all buttons with the class 'btn' using a different variable name, like 'btnElements'
  const btnElements = document.querySelectorAll('.btn');

  // Loop through each button
  btnElements.forEach(function(button) {
    // Add a click event listener to each button
    button.addEventListener('click', function() {
      // When a button is clicked, find the input field by its corrected ID 'inputFieldd'
      const inputFieldd = document.getElementById('inputFieldd');
      // Set the value of the input field to the 'data-table' attribute of the clicked button
      inputFieldd.value = this.getAttribute('data-table');
    });
  });
</script>

  <script>
document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('mouseover', function() {
        var tableNumber = this.getAttribute('data-table');
        fetchReservations(tableNumber);
    });
    
    // Add this event listener for mouseout
     button.addEventListener('mouseout', function() {     //ZA VRACANJE MISA, GASENJE POPUP-a
    //     // Clear the reservations display
        var reservationsDiv = document.getElementById('reservations');
        reservationsDiv.innerHTML = '<i class="bi bi-filter-left"></i>'; // Or set it to some default message like 'Hover over a table to see reservations.'
     });
});

function fetchReservations(tableNumber) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '2fetch_reservations.php?table_number=' + tableNumber);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var times = JSON.parse(xhr.responseText);
            var reservationsDiv = document.getElementById('reservations');
            reservationsDiv.innerHTML = '<strong>Sto: ' + tableNumber + '<br></strong> ' + 
    (times.length ? times.map(time => time.substring(0, time.lastIndexOf(":"))).join('<br>') : 'Slobodan');
        } else {
            console.error('Request failed. Returned status of ' + xhr.status);
        }
    };
    xhr.send();
}
</script>

  

  <script>
  // Function to get date string with a specific offset
  function getDateString(offset) {
    const today = new Date();
    const targetDate = new Date(today);
    targetDate.setDate(today.getDate() + offset);
    return targetDate.toDateString();
  }

  // Function to update button text
  function updateButtonText() {
    document.getElementById('todayBtn').innerText = getDateString(0);
    document.getElementById('tomorrowBtn').innerText = getDateString(1);
    document.getElementById('dayAfterTomorrowBtn').innerText = getDateString(2);
    document.getElementById('day3Btn').innerText = getDateString(3);
    document.getElementById('day4Btn').innerText = getDateString(4);
    document.getElementById('day5Btn').innerText = getDateString(5);
    document.getElementById('day6Btn').innerText = getDateString(6);
  }

  // Update button text on page load
  updateButtonText();
</script>


<script>
function toggleDivs() {
  var div1 = document.getElementById('div1');
  var div2 = document.getElementById('div2');
  
  if (div1.style.display !== 'none') {
    div1.style.display = 'none';
    div2.style.display = 'block';
  } else {
    div1.style.display = 'block';
    div2.style.display = 'none';
  }
}
</script>


<script>
  function toggleForm(button) {
    var formContainer = button.parentElement.querySelector('.form-container');
    formContainer.style.display = (formContainer.style.display === 'block') ? 'none' : 'block';
  }
</script>

<script>
  function ukljuciForm(button) {  //Za odbijanje rezervacije
    var formContainer = button.parentElement.querySelector('.form-container-odbi');
    formContainer.style.display = (formContainer.style.display === 'block') ? 'none' : 'block';
  }
</script>

<script>
    const buttons = document.querySelectorAll('.btn');
    const tableNumberInput = document.getElementById('inputField');

    buttons.forEach(button => {
        button.addEventListener('click', () => {
            const tableNumber = button.getAttribute('data-table');
            tableNumberInput.value = tableNumber;
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.btn');
    
    // Function to update button colors based on reservation status
    function updateButtonColors() {
        fetch('2CRST.php')
            .then(response => response.json())
            .then(data => {
                buttons.forEach(button => {
                    const tableNumber = button.getAttribute('data-table');
                    const reservationStatus = data[tableNumber];
                    if (reservationStatus === 'pending') {
                        button.classList.remove('btn-green', 'btn-red');
                        button.classList.add('btn-orange');
                    } else if (reservationStatus === 'approved') {
                        button.classList.remove('btn-orange', 'btn-green');
                        button.classList.add('btn-red');
                    } else if (reservationStatus === 'rejected') {
                        button.classList.remove('btn-orange', 'btn-red');
                        button.classList.add('btn-green');
                    }
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Initial update of button colors
    updateButtonColors();
});

</script>




<script>
  document.addEventListener('DOMContentLoaded', function() { //Otvaranje popup forme za ubacivanje rezervacija preko poziva telefona
  const icon = document.getElementById('plus-icon');
  const form = document.getElementById('popup-form');
  
  icon.addEventListener('click', function() {
    if (form.style.display === 'none') {
      form.style.display = 'block';
    } else {
      form.style.display = 'none';
    }
  });
});
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get today's date
        var today = new Date();
        
        // Add one day to get tomorrow's date
        var tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 2);

        // Format tomorrow's date as yyyy-mm-dd
        var formattedDate = tomorrow.toISOString().split('T')[0];
        
        // Set the value of the input field to tomorrow's date
        document.getElementById('zadatum').value = formattedDate;
    });
</script>
  

</body>

</html>
<?php
        } else {
          ?>
           
            <script>
                alert("You are not authorized to access this page.");
            </script>
            <?php
        }
    } else {
        // Handle case where no manager found with the given ID
        echo "Manager not found.";
    }
}



?>