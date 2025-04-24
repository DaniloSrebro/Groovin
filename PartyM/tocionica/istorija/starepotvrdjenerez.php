<?php
include 'dbconnect.php';

$conn = new mysqli($servername, $username, $password, $database);


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

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">
  <link href="../../assets/css/djpit.css" rel="stylesheet">

  <style>
    body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #2e2e2e;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-style: italic;
}

/* Styling the reservation container */
.reservation-container {
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    max-width: 98%;
    overflow-x: auto;
}

/* Basic reset for the table */
.reservation-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.reservation-table th, .reservation-table td {
    text-align: left;
    padding: 12px;
    border-bottom: 1px solid #eee;
}

.reservation-table th {
    background-color: #008fb3;
    color: #ffffff;
    font-weight: normal;
}

/* Highlight for the table rows on hover */
.reservation-table tr:nth-child(even){background-color: #f2f2f2;}

.reservation-table tr:hover {
    background-color: #ddd;
    cursor: pointer;
}

/* Styling for status indicators */
.status {
    padding: 6px 12px;
    border-radius: 20px;
    color: black;
    font-weight: bold;
    text-transform: uppercase;
    display: inline-block;
}



/* Button styling */
.button {
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    background-color: #008fb3;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #007b9b;
}

/* Responsive Design: Adjusting for smaller screens */
@media screen and (max-width: 768px) {
    .reservation-container {
        width: 95%;
        margin: 20px auto;
    }

    .reservation-table {
        display: block;
        overflow-x: auto;
    }
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
        <li><a class="nav-link" href="../rezervacije/tocionicamenadzer.php">Rezervacije</a></li> 
        
        <li class="dropdown" id="rez"><a href="#"><span>Istorija</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
            <li><a class="nav-link" href="#">Potvrđene Rezervacije</a></li>
           <li><a class="nav-link" href="./nepotvrdjenerez.php">Nepotvrđene Rezervacije</a></li>
           <li><a class="nav-link" href="odbijenerez.php" style="background-color:red">Odbijene Rezervacije</a></li>
              
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

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center" style="color:white">
          <h2>Potvrđene rezervacije</h2>
          <ol>
            <li><a href="../rezervacije/tocionicamenadzer.php">Menadžer</a></li>
            <li>Istorija</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->
    
    

    
    

    <?php
// Database connection details
include 'dbconnect.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// SQL query to retrieve reservations
$sql_select = "SELECT rez_id, ime, vrstarez, brojtelefona, brojstola, brojljudi, reservationstatus, zadatum, vremerez, mesto, vremedolaska, mestosedenja, sedenje, email FROM tocionicaistorija WHERE dosli='da' ORDER BY zadatum desc";

// Execute query
$result = $conn->query($sql_select);

// Check if there are results
if ($result->num_rows > 0) {
  echo "<div class='reservation-container'>";
  // Output data as a table
  echo "<table class='reservation-table'>";
  echo "<tr>
          <th>Br.</th>
          <th>Ime</th>
          <th>Email</th>
          <th>Broj telefona</th>
          <th>Vrsta Rez.</th>
          <th>Broj stola</th>
          <th>Broj ljudi</th>
          <th>Status rezervacije</th>
          <th>Za dan</th>
          <th>Vreme Dolaska</th>
          <th>Mesto</th>
          <th>Sedenje</th>
        </tr>";

  while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td class='column-rez-id'>" . $row["rez_id"] . ".</td>";
      echo "<td class='column-ime'>" . $row["ime"] . "</td>";
      echo "<td class='column-email'>" . $row["email"] . "</td>";
      echo "<td class='column-broj-telefona'>" . $row["brojtelefona"] . "</td>";
      echo "<td class='column-vrsta-rez'>" . $row['vrstarez'] . "</td>";
      echo "<td class='column-broj-stola'>" . $row["brojstola"] . "</td>";
      echo "<td class='column-broj-ljudi'>" . $row["brojljudi"] . "</td>";
      echo "<td class='column-status'><span class='status'>" . $row['reservationstatus'] . "</span></td>";
      echo "<td class='column-za-dan'>" . $row['zadatum'] . "</td>";
      echo "<td class='column-vreme-dolaska'>" . $row['vremedolaska'] . "</td>";
      echo "<td class='column-mesto-sedenja'>" . $row['mestosedenja'] . "</td>";
      echo "<td class='column-sedenje'>" . $row['sedenje'] . "</td>";

      // Add buttons to approve, reject, or change to pending

      echo "</tr>";
  }
  echo "</table>";
  echo "</div>"; // Close reservation-container div

} else {
  echo "<p class='no-reservation'>Nema potvrdjenih rezervacija.</p>";
}

// Close connection
$conn->close();

?>







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
    <p style="color: white">Photo by <a href="https://unsplash.com/@anniespratt?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Annie Spratt</a> on <a href="https://unsplash.com/photos/black-textile-in-close-up-photography-gM8igOIP5MA?utm_content=creditCopyText&utm_medium=referral&utm_source=unsplash">Unsplash</a></p>
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
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>

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