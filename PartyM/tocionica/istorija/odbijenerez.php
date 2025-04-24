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
  <link href="../../assets/css/tocionicaistorija.css" rel="stylesheet">


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
            <li><a class="nav-link" href="./potvrdjenerez.php">Potvrđene Rezervacije</a></li>
           <li><a class="nav-link" href="./nepotvrdjenerez.php">Nepotvrđene Rezervacije</a></li>
           <li><a class="nav-link" href="#" style="background-color:red">Odbijene Rezervacije</a></li>
              
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
          <h2>Odbijene rezervacije</h2>
          <ol>
            <li><a href="../rezervacije/tocionicamenadzer.php">Menadžer</a></li>
            <li>Istorija</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->






    
    <?php
// Database connection details
include 'dbconnect2.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $database1);

// Check connection
if ($conn->connect_error) {
    die("Connection to 'rezervacije' failed: " . $conn->connect_error);
}

$default_image = 'https://bootdey.com/img/Content/avatar/avatar7.png';

// SQL query to retrieve reservations
$sql_select = "SELECT t.rez_id, t.id, t.Ime, t.brojtelefona, t.brojstola, t.vrstarez, t.brojljudi, t.reservationstatus, t.zadatum, t.vremedolaska, t.vremerez, t.mestosedenja, t.sedenje, u.profile_pic_url, u.email FROM rezervacije.tocionicaodbijene t LEFT JOIN login_db.user u ON t.id = u.id";


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
                  <th>Br.</th>
                  <th>Info</th>
                  <th>Broj telefona</th>
                  <th>Vrsta Rez.</th>
                  <th>Broj stola</th>
                  <th>Broj ljudi</th>
                  <th>Status rezervacije</th>
                  <th>Za dan</th>
                  <th>Vreme Dolaska</th>
                </tr>
              </thead>";


      echo "<tbody>";

      while ($row = $result->fetch_assoc()) {
        $time = new DateTime($row['vremedolaska']);
          echo "      <tr>";
          echo "<td>" . $row["rez_id"] . ".</td>";
          echo "
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
                  echo "<td>" . $row["brojtelefona"] . "</td>";
                  echo "<td class='vrstarezervacije'>
        " . $row["mestosedenja"] . "<br>" 
        . $row["sedenje"] . "<br>" 
        . $row["vrstarez"] . "
        </td>";
        echo "<td>" . $row["brojstola"] . "</td>";
        echo "<td>" . $row["brojljudi"] . "</td>";
        echo "<td>";
          if ($row["reservationstatus"] == "rejected") {
            echo '<span class="badge badge-pill badge-danger font-weight-normal">Rejected</span>';
          } else {
            echo $row["reservationstatus"];
          }
        echo "</td>";
        echo "<td>" . $row["zadatum"] . "</td>";
                  echo "<td>
            <div>" . $time->format('H:i') . "</div>
          </td>";
                  
                  
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