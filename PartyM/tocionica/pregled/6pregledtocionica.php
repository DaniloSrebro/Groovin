<?php
include 'dbconnect.php';

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$mysqli = new mysqli($servername, $username, $password, $database);

$query = "SELECT COUNT(*) AS row_count FROM tocionica WHERE zadatum = CURDATE() AND reservationstatus='approved'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
$row_count_variable = $row['row_count'];


$query = "SELECT COUNT(*) AS row_count FROM tocionica WHERE zadatum = DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND reservationstatus='approved'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
$row_count_variable1 = $row['row_count'];

$query = "SELECT COUNT(*) AS row_count FROM tocionica WHERE zadatum = DATE_ADD(CURDATE(), INTERVAL 2 DAY) AND reservationstatus='approved'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
$row_count_variable2 = $row['row_count'];

$query = "SELECT COUNT(*) AS row_count FROM tocionica WHERE zadatum = DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND reservationstatus='approved'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
$row_count_variable3 = $row['row_count'];

$query = "SELECT COUNT(*) AS row_count FROM tocionica WHERE zadatum = DATE_ADD(CURDATE(), INTERVAL 4 DAY) AND reservationstatus='approved'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
$row_count_variable4 = $row['row_count'];

$query = "SELECT COUNT(*) AS row_count FROM tocionica WHERE zadatum = DATE_ADD(CURDATE(), INTERVAL 5 DAY) AND reservationstatus='approved'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
$row_count_variable5 = $row['row_count'];

$query = "SELECT COUNT(*) AS row_count FROM tocionica WHERE zadatum = DATE_ADD(CURDATE(), INTERVAL 6 DAY) AND reservationstatus='approved'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();
$row_count_variable6 = $row['row_count'];

$mysqli->close();

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
  <link href="../../assets/css/tocionicapregled.css" rel="stylesheet">



  <style>
    body {
    overflow-x: hidden; /* Prevent horizontal scrolling */
    background-color: #141b2d !important;
     font-family: "PT Sans", sans-serif;
    font-style: italic;
     
}
@media only screen and (max-width: 800px) {
body {
overflow-x: hidden; /* Prevent horizontal scrolling */
background-color: #141b2d !important;
font-family: "PT Sans", sans-serif;
font-style: italic;
}
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
  width: 90%;
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
tr td:nth-child(n+7),tr th:nth-child(n+7) {
    border-radius: 0 .625rem .625rem 0;
}


tr td:nth-child(1),tr th:nth-child(1){border-radius: .625rem 0 0 .625rem;}



tr td:nth-child(3),
tr td:nth-child(4),
tr td:nth-child(5),
tr td:nth-child(6),
tr td:nth-child(7),
tr td:nth-child(8),
tr th:nth-child(3),
tr th:nth-child(4),
tr th:nth-child(5),
tr th:nth-child(6),
tr th:nth-child(7),
tr th:nth-child(8){
  text-align: center;
}


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


.popuppromeni {
display: none;
position: fixed;
top: 50%;
left: 50%;
transform: translate(-50%, -50%);
box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
background-color: #fff;
padding: 20px;
border-radius: 8px;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
z-index: 9999; /* Ensure popup appears above other content */
text-align: center;
}

.edit-icon{
  color: #6C757D;
  margin-right: 5px;
  font-size: 24px;
}

.containersmesti{
  justify-content: center;
  font-size: 24px;
}


.modal {
    display: none; 
    position: fixed; 
    z-index: 999; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; 
    background-color: rgba(0, 0, 0, 0.8);
}

/* Modal Content (the Image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
}

/* The Close Button */
.close {
    position: absolute;
    top: 20px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

.upitnik{
  cursor: pointer;
  color: #00d68f;
  font-size: 16px;
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
          
        <li><a class="nav-link active" href="#">Pregled</a></li> 
        <li  id="rez"><a class="nav-link" href="../rezervacije/tocionicamenadzer.php">Rezervacije</a></li> 
        
        <li class="dropdown"><a href="#"><span>Istorija</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
            <li><a class="nav-link" href="../istorija/potvrdjenerez.php">Potvrđene rezervacije</a></li>
           <li><a class="nav-link" href="../istorija/nepotvrdjenerez.php">Nepotvrđene rezervacije</a></li>
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
      
    <a href="./pregledtocionica.php"><button class="button1" id="todayBtn">Today</button><br><p style="color:white; margin-left: 48%;"><?php echo $row_count_variable; ?></p></a>
    <a href="./1pregledtocionica.php"><button class="button1" id="tomorrowBtn">Tomorrow</button><br><p style="color:white; margin-left: 48%;"><?php echo $row_count_variable1; ?></p></a>
    <a href="./2pregledtocionica.php"><button class="button1" id="dayAfterTomorrowBtn">Day after Tomorrow</button><br><p style="color:white; margin-left: 48%;"><?php echo $row_count_variable2; ?></p></a>
    <a href="./3pregledtocionica.php"><button class="button1" id="day3Btn">In 3 Days</button><br><p style="color:white; margin-left: 48%;"><?php echo $row_count_variable3; ?></p></a>
    <a href="./4pregledtocionica.php"><button class="button1" id="day4Btn">In 4 Days</button><br><p style="color:white; margin-left: 48%;"><?php echo $row_count_variable4; ?></p></a>
    <a href="./5pregledtocionica.php"><button class="button1" id="day5Btn">In 5 Days</button><br><p style="color:white; margin-left: 48%;"><?php echo $row_count_variable5; ?></p></a>
    <a href="#"><button class="button1" id="day6Btn" style="background-color: #ffc506;">In 6 Days</button><br><p style="color:white; margin-left: 48%;"><?php echo $row_count_variable6; ?></p></a>
    </div>






<div id="hidden" style="display: none"></div>

    <h2 class="nadolazece">Nadolazeće rezervacije:</h2>

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
$sql_select = "SELECT t.id, t.Ime, t.brojtelefona, t.brojstola, t.vrstarez, t.brojljudi, t.reservationstatus, t.zadatum, t.vremedolaska, t.vremerez, t.mestosedenja, t.sedenje, u.profile_pic_url, u.email FROM rezervacije.tocionica t LEFT JOIN login_db.user u ON t.id = u.id WHERE t.zadatum = DATE_ADD(CURDATE(), INTERVAL 6 DAY) AND t.reservationstatus = 'approved' ORDER BY t.vremedolaska ASC";


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
                  <th>Sto</th>
                  <th>Osobe</th>
                  <th>Dolazak</th>
                  <th>Vrsta</th>
                  <th>Telefon</th>
                  <th>Akcije</th>
            
                </tr>
              </thead>";


      echo "<tbody>";
      date_default_timezone_set('Europe/Belgrade');
      while ($row = $result->fetch_assoc()) {
        $time = new DateTime($row['vremedolaska']);
        
        



          echo "<tr>";
          
      
               
        
              echo"<td>
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
                  echo "
<td class='table-cell'>" . $row["brojstola"] . "
    <span class='broj-stola-red' onclick='showImage(\"../../assets/img/tocionica/stolovi/" . $row["brojstola"] . ".jpg\")'>
      <i class='bi bi-question-circle upitnik'></i>
    </span>
</td>";
                  echo "<td>
            <div>" . $row["brojljudi"] . "</div>
          </td>";
          echo "<td>
            <div>" . $time->format('H:i') . "</div>
          </td>";
                  echo "<td class='vrstarezervacije'>" . $row['vrstarez'] . "</td>";
                  echo "<td class='vrstarezervacije'>" . $row["brojtelefona"] . "</td>";

                  echo "<td>
                  <div class='containersmesti' style='display: flex; align-items: center; gap: 10px;'>
                      <button onclick='toggleForm(this)' class='icon-button'>
                          <a href='#' class='text-secondary mr-2'>
                              <i class='material-icons-outlined edit-icon'>edit</i>
                          </a>
                      </button>
                      <div class='popuppromeni' style='display: none; font-size: 20px; color:black;'>
                          <form method='post' action='../akcije/podesi/6podesi.php'>
                              <input type='hidden' name='reservation_id' value='" . $row["id"] . "'>
                              <label for='inputField'>Novi Sto:</label><br>
                              <input type='number' id='inputField' placeholder='Broj stola../..' class='promenistoinput' name='inputField' required><br>
                              <button type='submit' class='promenidugme'>Promeni</button>
                          </form>
                          <br>
                          <p>ili</p>
                          <form method='post' action='../akcije/vrati/6vrati.php'>
                              <input type='hidden' name='reservation_id' value='" . $row["id"] . "'>
                              <button type='submit' class='vratidugme'>Pending</button>
                          </form>
                      </div>
                  </div>
              </td>";
                      
                    
                  
           
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
      
  echo "</div></td>"; // Close reservation-container div

} else {
  echo "<p class='no-reservation' style='color:#bbc0c6;'>Nema trenutnih rezervacija.</p>";
  echo "</div>";
}

// Close connection
$conn->close();

?> 

<div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
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
    window.location.href = './pregledtocionica.php';
}

// Add event listeners for mousemove and click events to reset the idle timer
document.addEventListener('mousemove', resetIdleTimer);
document.addEventListener('click', resetIdleTimer);

// Start the idle timer initially
resetIdleTimer();
</script>




<script>
function checkForNewReservation1() {
    <?php
    // Connect to your database
    include 'dbconnect.php';

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if there's a row with tomorrow's date and reservation status pending
    
    $sql = "SELECT * FROM tocionica WHERE reservationstatus = 'pending' AND zadatum BETWEEN CURDATE() AND CURDATE() + INTERVAL 6 DAY;";
    $result = $conn->query($sql);

    // Output JavaScript code based on the query result
    echo "if (" . $result->num_rows . " > 0) {";
      echo "  document.getElementById('rez').classList.add('shine');"; // Change '.glowing' to '.shine'
      echo "} else {";
      echo "  document.getElementById('rez').classList.remove('shine');"; // Change '.glowing' to '.shine'
      echo "}";

    $conn->close();
    ?>
}

// Check for updates every 5 seconds
setInterval(checkForNewReservation1, 1000);
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
// Function to reload the page every 60 seconds
function reloadPage() {
    location.reload();
}

// Reload the page every 60 seconds
setInterval(reloadPage, 60000); // 60,000 milliseconds = 60 seconds
</script>


<script>
  function openPopup() {
    document.getElementById('popup').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}
</script>

<script>
function closePopupPromeni() {
    document.getElementsByClassName('popuppromeni').style.display = 'none';
}
</script>


<script>
  function toggleForm(button) {
    var formContainer = button.parentElement.querySelector('.popuppromeni');
    formContainer.style.display = (formContainer.style.display === 'block') ? 'none' : 'block';
}

</script>

<script>
  var inputField = document.getElementById('inputField');

// Set the minimum and maximum values
inputField.setAttribute('min', '1');
inputField.setAttribute('max', '40');
</script>


<script>
function showImage(src) {           // za hover slike
    document.getElementById('imageModal').style.display = 'block';
    document.getElementById('modalImage').src = src;
}

function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
}
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