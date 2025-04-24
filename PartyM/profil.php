<?php
session_start(); // Start session at the beginning

$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['user_id'])) {
  // Redirect to login page if user is not logged in
  header("Location: ./forms/Login.php");
  exit();
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "rezervacije";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Load user info if logged in
$user = null; // Define $user variable to avoid undefined variable notice
if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/forms/database.php";
    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

$isLoggedIn = isset($_SESSION["user_id"]);

// Close the MySQL connection
$conn->close();

$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "login_db";

$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT bodovi AS rankbodovi FROM user WHERE id = {$_SESSION["user_id"]}";
$result = $mysqli->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $bodovi = $row['rankbodovi'];
    if($bodovi < 3){
      $message = "CloudBurst";
    }
    elseif ($bodovi > 3 && $bodovi <= 5) {
      $message = "Storm";
    }
    elseif ($bodovi > 5 && $bodovi <= 9) {
      $message = "Tornado";
    }
    elseif ($bodovi > 9 && $bodovi <= 15) {
      $message = "Hurricane";
    }
    elseif ($bodovi > 15 && $bodovi < 20) {
        $message = "Monsoon";
    } elseif ($bodovi >= 20 && $bodovi <= 40) {
        $message = "Typhoon";
    } else {
        $message = "Cyclone";
    }
} else {
    echo "Query failed: " . $mysqli->error;
}


$mysqli->close();
?>

<?php
    $userime = htmlspecialchars($user["username"]);
        $email = htmlspecialchars($user["email"]);
?>

<?php


// Database connection
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$dbname = "login_db";

$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$profile_pic_url = 'https://bootdey.com/img/Content/avatar/avatar7.png'; // Default image initialization

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Query to get the user's profile picture URL
    $stmt = $mysqli->prepare("SELECT profile_pic_url FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the user's profile picture URL
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $profile_pic_url = !empty($user['profile_pic_url']) ? $user['profile_pic_url'] : $profile_pic_url;
    } 
}

// Close the database connection
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profil</title>
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

  

  <link rel="stylesheet" href="./assets/css/styleprofil.css">

<link rel="stylesheet" href="./assets/css/demo.css">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="./assets/css/profil.css" rel="stylesheet">

  

 


<style>
  

  * {
    margin: 0;
    padding: 0
}

body {
    background-color: #000
}

.card {
    width: 350px;
    background-color: #efefef;
    border: none;
    cursor: pointer;
    transition: all 0.5s;
    
}
.card-body {
    font-style: normal;
    background: rgb(255, 255, 255); /* Transparent background with blue-purple tint */
    backdrop-filter: blur(10px); /* Glass effect */
    -webkit-backdrop-filter: blur(10px); /* Safari support */
    border-radius: 12px; /* Rounded corners for a softer look */
    border: 1px solid rgba(2, 73, 4, 0.46); /* Subtle border for depth */
    
}
.image img {
    transition: all 0.5s;
    border-radius: 15%;
}




.name {
    font-size: 22px;
    font-weight: bold
}

.idd {
    font-size: 14px;
    font-weight: 600
}

.idd1 {
    font-size: 12px
}

.number {
    font-size: 22px;
    font-weight: bold
}

.follow {
    font-size: 12px;
    font-weight: 500;
    color: #444444
}

.btn1 {
    height: 40px;
    width: 150px;
    border: none;
    background-color: #000;
    color: #aeaeae;
    font-size: 15px
}

.text span {
    font-size: 13px;
    color: #545454;
    font-weight: 500
}

.icons i {
    font-size: 19px
}

hr .new1 {
    border: 1px solid
}

.join {
    font-size: 14px;
    color: #a0a0a0;
    font-weight: bold
}

.date {
    background-color: #ccc
}

.hidden {
    display: none;
}
.istorijatabela {
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;
}

.istorijatabela th, 
.istorijatabela td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
    color: #333;
}

.istorijatabela th {
    background-color: #4b137d;
    color: white;
    font-weight: bold;
}

.istorijatabela tr:nth-child(even) {
    background-color: #f9f9f9;
}

.no-reservations {
    color: #4b137d;
    font-size: 14px;
    text-align: center;
    margin-top: 10px;
}
.buttons {
  margin-bottom: 10px;
  text-align: center;
}

.toggle-button {
  background-color: #4b137d;
  color: white;
  border: none;
  padding: 10px 20px;
  margin: 5px;
  cursor: pointer;
  border-radius: 5px;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.toggle-button:hover {
  background-color: #6f38a9;
}


/* Style the "Choose a file" label button */
.custom-file-upload {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4b137d; /* Your main site color */
    color: white;
    font-size: 14px;
    cursor: pointer;
    border-radius: 5px;
    border: none;
    text-align: center;
    transition: background-color 0.3s ease;
}

/* Remove the default file input appearance */
input[type="file"] {
    display: none;
}

/* Hover effect for the custom file button */
.custom-file-upload:hover {
    background-color: #370e5c; /* Darker shade of the main color */
}

/* Style for displaying the chosen file name */
.file-name {
    margin-top: 5px;
    font-size: 12px;
    color: #333;
}

.btn img {
  width: 100px; /* Set a fixed width */
  height: 100px; /* Set the same height to maintain a perfect circle */
  border-radius: 50%; /* Make it a circle */
  object-fit: cover; /* Ensure the image covers the circle without stretching */
}


.toggle-btn {
            background-color: #4b137d;
            color: white;
            font-size: 13px;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
            
            margin-left: 50%;
            transform: translateX(-50%);
        }

</style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      
      <h1 class="logo"><a href="index.html">Party M</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      

<nav id="navbar" class="navbar">
        <ul>
          
          <li><a class="nav-link scrollto" href="./index.php">Početna</a></li>
         
          
          
        
          
         
          <li class="dropdown"><a href="#"><span>Lokali</span> <i class="bi bi-chevron-down"></i></a>
            <ul>

              
              <li><a href="./restoranikafici.php">Restorani i Kafići</a></li>
              
              
            </ul>
            <li class="dropdown"><a href="#"><span>HotCue</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              
              
              <li><a href="./dj.php">DJ</a></li>
              <li><a class="nav-link" href="./events.php">Events</a></li>
              
            </ul>
            <li><a class="nav-link active" href="./profil.php">Profil</a></li>
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

        <div class="d-flex justify-content-between align-items-center" style="color: white;">
        <h2 style="color:white">Profil</h2>
          <ol>
            <li><a href="index.php">Party M</a></li>
            <li>Profil</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

  
     


    <div class="container mt-4 mb-4 p-3 d-flex justify-content-center"> 
      <div class="card p-4"> 
        <div class=" image d-flex flex-column justify-content-center align-items-center"> 
          <button class="btn"> <img src="<?php echo htmlspecialchars($profile_pic_url); ?>" height="100" width="100"></button> 
          <span class="name mt-3"><?php echo $userime; ?></span> <span class="idd"><?php echo $message; ?></span> <div class="d-flex flex-row justify-content-center align-items-center gap-2"> <span class="idd1"><?php echo $email; ?></span>
           <span><i class="fa fa-copy"></i></span> </div>
            <div class="d-flex flex-row justify-content-center align-items-center mt-3"> 
              <span class="number"><?php echo $bodovi; ?> <span class="follow">Passes</span></span> </div> 
              
              

              <div class="buttons">
    <button class="toggle-button" onclick="toggleForm()">Change Photo</button>
</div>

<div class="form-container" id="formContainer" style="display: none;">
    <form id="uploadForm" action="process_upload.php" method="POST" enctype="multipart/form-data" class="upload-form">
        <label for="profile-pic" class="custom-file-upload">
            <input type="file" id="profile-pic" name="profile_pic" accept="image/*" required onchange="autoSubmit()" />
            Choose a file
        </label>
        <p id="file-name" class="file-name" style="display: none;color:black; font-size: 10px;">No file chosen</p> <!-- Initially hidden -->
    </form>
</div>


<script>
  function toggleForm() {
    var formContainer = document.getElementById("formContainer");
    formContainer.style.display = (formContainer.style.display === "none" || formContainer.style.display === "") ? "block" : "none";
}

function autoSubmit() {
    var fileInput = document.getElementById('profile-pic');
    var fileNameDisplay = document.getElementById('file-name');

    if (fileInput.files.length > 0) {
        // Show the chosen file name
        fileNameDisplay.style.display = 'block';
        fileNameDisplay.textContent = fileInput.files[0].name;

        // Automatically submit the form
        document.getElementById('uploadForm').submit();
    }
}

</script>


              <div class="text mt-3 rezervacije" style="display: block;"> 
                
              <?php

$user_db_host = "localhost";
$user_db_username = "root";
$user_db_password = "Sinke008";
$user_db_name = "login_db"; 

$reservations_db_host = "localhost";
$reservations_db_username = "root";
$reservations_db_password = "Sinke008";
$reservations_db_name = "rezervacije"; 


$user_conn = mysqli_connect($user_db_host, $user_db_username, $user_db_password, $user_db_name);

if (!$user_conn) {
    die("User database connection failed: " . mysqli_connect_error());
}


$reservations_conn = mysqli_connect($reservations_db_host, $reservations_db_username, $reservations_db_password, $reservations_db_name);


if (!$reservations_conn) {
    die("Reservations database connection failed: " . mysqli_connect_error());
}




if (!isset($_SESSION['user_id'])) {
  
    header("Location: ./forms/Login.php");
    exit();
}


$user_id = $_SESSION['user_id'];


$sql_tocionica = "SELECT * FROM $reservations_db_name.tocionica WHERE id = $user_id";


$result_tocionica = mysqli_query($reservations_conn, $sql_tocionica);



if (mysqli_num_rows($result_tocionica) > 0) {
  
    while ($row = mysqli_fetch_assoc($result_tocionica)) {
        displayReservation($row);
    }
}
if (mysqli_num_rows($result_tocionica) === 0) {
  echo "<div class='px-2 py-1'> <h5 class='mb-0'>Rezervacije</h5><br><p>Trenutno nemate rezervacije.</div><hr>";
  while ($row = mysqli_fetch_assoc($result_tocionica)) {
      displayReservation($row);
  }
}


function displayReservation($row) {
    
    
    






echo"
            <div class='px-2 py-1'> 
                <h5 class='mb-0'>Rezervacije</h5> 


            <div class='rounded shadow-sm'> 
            <div class='container23'>
        <div class='card mt-3 border-5 px-3'>
            <div class='card-body'>
                <div class='row'>
                    <div class='col-12 '>";
                    echo "<h4 class='card-title '><b>" . 
                    ($row['mesto'] === 'tocionica' ? 'Точионица Паб' : htmlspecialchars($row['mesto'])) . 
                    "</b></h4>";

                  echo "  </div>
                    <div class='col'>
                        <h6 class='card-subtitle mb-2 text-muted'>
                            <p class='card-text text-muted small '>";
                            echo "<span class='reservation-status'>";
                            if ($row['reservationstatus'] === 'approved') {
                                echo "<i class='bi bi-check-circle' style='color:green'></i> Approved";
                            } elseif ($row['reservationstatus'] === 'rejected') {
                                echo "<i class='bi bi-x-circle' style='color:red'></i> Rejected";
                            }elseif ($row['reservationstatus'] === 'pending') {
                                echo "<i class='bi bi-hourglass-split blink' style='color:orange'></i> Pending";
                            }
                             else {
                                echo "<i class='bi bi-hourglass-split' style='color:orange'></i> " . htmlspecialchars($row['reservationstatus']);
                            }
                            echo "<span class='vl mr-2 ml-0'></span></span>";

                             echo "   Za <span class='font-weight-bold'> " . $row['zadatum'] . "</span> u " . $row['vremedolaska'] . "</p>
                        </h6>";
                         if (!empty($row['kasnjenje'])) {
    echo "<p><strong>Kašnjenje:</strong> 
     <span style='color: black;'>
       " . $row['kasnjenje'] . " min</span></p>";
    };
             echo "       </div>
                </div>

            </div>

            
                <div class='row'>";




                if ($row['reservationstatus'] == 'approved') {

               echo"     <div class=' col-md-auto '>

                        <a href='#' class='btn btn-outlined btn-black text-muted bg-transparent linkovi'
                            data-wow-delay='0.7s' data-toggle='modal' data-target='#ratingModal'><i class='bi bi-star' width='19' height='19'></i> <small>OCENI</small></a>

                        <i class='mdi mdi-settings-outline'></i>


                        <a onclick='openPopup()' class='btn btn-outlined btn-black text-muted bg-transparent linkovi'><i class='bi bi-trash3' width='19' height='19'></i>
                            <small>DELETE</small> </a>

                        <a data-toggle='modal' data-target='#lateArrivalModal' class='btn btn-outlined btn-black text-muted bg-transparent linkovi' data-dismiss='modal' aria-label='Close'><i class='bi bi-clock-history' width='19' height='19'></i><small aria-hidden='true'> KASNJENJE</small></a>
                        

</div>

<div class='modal fade' id='ratingModal' tabindex='-1' aria-labelledby='ratingModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='ratingModalLabel'>Rate Us</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form method='post' action='" . $row['mesto'] . "process_rating.php'>
                    <div class='rating' style='font-style: normal;'>
                        <input value='5' name='rating' id='star5' type='radio'>
                        <label for='star5'></label>
                        <input value='4' name='rating' id='star4' type='radio'>
                        <label for='star4'></label>
                        <input value='3' name='rating' id='star3' type='radio'>
                        <label for='star3'></label>
                        <input value='2' name='rating' id='star2' type='radio'>
                        <label for='star2'></label>
                        <input value='1' name='rating' id='star1' type='radio'>
                        <label for='star1'></label>
                    </div>
                    <button type='submit' class='ocenidugme'><span>Oceni</span></button>
                </form>
            </div>
        </div>
    </div>
</div>";

echo"   

<!-- Modal -->
<div class='modal fade' id='lateArrivalModal' tabindex='-1' role='dialog' aria-labelledby='lateArrivalModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='lateArrivalModalLabel'>Prijavi Kašnjenje</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>


            <div class='modal-body'>
                <form method='post' action='kasni.php' id='lateArrivalForm'>
                    <input type='hidden' name='user_id' value='" . $_SESSION['user_id'] . "'>
                    <label for='delay' class='delay-label'>Odredi vreme kašnjenja:</label>
<select name='delay' id='delay' required class='delay-select'>
    <option value='15'>15 Minutes</option>
    <option value='30'>30 Minutes</option>
    <option value='45'>45 Minutes</option>
</select>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Odustani</button>
                <button type='submit' class='btn btn-primary'>Pošalji</button>
                </form>
            </div>
            
        </div>
    </div>
</div>
</div>";



if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']); // Clear the message after displaying it
}

// Check for error message
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']); // Clear the message after displaying it
}
            
  
    }elseif ($row['reservationstatus'] == 'rejected') {
        
    } elseif ($row['reservationstatus'] == 'pending') {
        echo "<a onclick='openPopup()' class='btn btn-outlined btn-black text-muted bg-transparent linkovi'><i class='bi bi-trash3' width='19' height='19'></i>
                            <small>DELETE</small> </a>";
    }

    

    echo "<div id='popup' style='display: none;'>";
    echo "<form id='deleteForm' method='POST'>";
    echo "<input type='hidden' name='user_id' value='" . $_SESSION['user_id'] . "'>";
    echo "<input type='hidden' name='mesto' value='" . $row['mesto'] . "'>";
    echo "<button class='button-45' type='submit' name='delete_reservation'>Potvrdi</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";


    echo "</div>";
    echo "<hr>";
}

// Handle reservation deletion
if(isset($_POST['delete_reservation'])) {
    $user_id = $_POST['user_id'];
    $mesto = $_POST['mesto'];

    // Construct your SQL query with user ID and reservation details
    $sql = "DELETE FROM $mesto WHERE id = '$user_id' AND mesto = '$mesto'";

    // Execute the query
    $result = mysqli_query($reservations_conn, $sql);

    // Check if the query was successful
    if ($result) {
        echo "Rezervacija uspešno obrisana.";
        echo "<script>window.location.href = window.location.href;</script>";
    } else {
        echo "Error deleting reservation: " . mysqli_error($reservations_conn);
    }
}

// Close the connections
mysqli_close($user_conn);
mysqli_close($reservations_conn);
?>
                

              
                 </div> 

                 <div class="following">
                <?php
$servername = "localhost";
$username = "root";
$password = "Sinke008";
$database = "djlikes";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get liked DJs with profile information and live status
$sql = "SELECT 
            mikula.dj_id, 
            dj.username, 
            dj.profile_picture, 
            dj.live 
        FROM mikula
        INNER JOIN login_db.dj ON mikula.dj_id = dj.id
        WHERE mikula.user_id = ?";

// Prepare the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION["user_id"]);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are any rows returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div style="display: flex; align-items: center; gap: 15px;margin-top:15px; margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">';

        // Profile picture
        if (!empty($row['profile_picture'])) {
            echo '<img src="./djs/uploads/profile_pictures/' . htmlspecialchars($row['profile_picture']) . '" 
                 alt="Profile Picture" 
                 style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">';
        } else {
            echo '<div style="width: 60px; height: 60px; border-radius: 50%; background-color: #ccc; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #555;">No Image</div>';
        }

        // DJ name with link and live status
        echo '<div>';
        echo '<a href="./djs/profile.php?id=' . htmlspecialchars($row['dj_id']) . '" style="font-size: 18px; font-weight: 500; color: #333; text-decoration: none;">' . htmlspecialchars($row['username']) . '</a>';
        echo '<div style="font-size: 14px; color: #666;">Following</div>';

        // Display "Live" status
        if ($row['live']) {
            echo '<div style="font-size: 14px; color: #666;"><i class="bi bi-broadcast" style="color: red;"></i>  Live</div>';
        }

        echo '</div>';

        echo '</div>';
    }
} else {
    echo '<div style="font-size: 18px; color: #555; text-align: center;">You haven’t liked any DJs yet.</div>';
}

// Close the database connection
$conn->close();
?>



</div>


                 <button id="toggleBtn" class="toggle-btn">Prikaži istoriju</button>


                <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center"> 
                  
                <div class="istorijatabela-container" id="istorija_sakriveno" style="display: none;"> 
    <?php
    // Database connection settings
    $servername = "localhost";
    $username = "root";
    $password = "Sinke008";
    $dbname = "rezervacije";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // User ID
    $user_id = $_SESSION["user_id"]; // Adjust this variable based on your session setup

    // SQL query to fetch data from the tocionicaistorija table for the given user ID
    $sql = "SELECT * FROM tocionicaistorija WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='istorijatabela'>";
        echo "<thead>
              <tr>
                  <th>Mesto</th>
                  <th>Datum</th>
                  <th>Vreme Dolaska</th>
                  <th>Vrsta Rezervacije</th>
              </tr>
              </thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            if ($row['mesto'] === 'tocionica') {
                echo "Точионица Паб";
            } else {
                echo "Bag... ";
            }
            echo "</td>";
            echo "<td>" . htmlspecialchars($row["zadatum"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["vremedolaska"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["vrstarez"]) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p class='no-reservations'>Nemate potvrđenih rezervacija.</p>";
    }

    $conn->close();
    ?>
</div>



              </div> 
                </div> 

                

                  </div>
                 
                    </div>



                    

<script>
// Get buttons and divs
const toggleFollowingButton = document.getElementById("toggleFollowing");
const rezervacijeButton = document.getElementById("showRezervacije");
const followingDiv = document.querySelector(".following");
const rezervacijeDiv = document.querySelector(".rezervacije");

// Toggle visibility of the following div and hide rezervacije div
toggleFollowingButton.addEventListener("click", () => {
  // When toggle following is clicked, check if following is visible
  if (followingDiv.style.display === "none" || followingDiv.style.display === "") {
    followingDiv.style.display = "block";  // Show the following div
    rezervacijeDiv.style.display = "none"; // Hide the rezervacije div
  } else {
    followingDiv.style.display = "none"; // Hide the following div
  }
});

// Show rezervacije div and hide following div
rezervacijeButton.addEventListener("click", () => {
  followingDiv.style.display = "none"; // Hide the following div
  rezervacijeDiv.style.display = "block"; // Show the rezervacije div
});


</script>
















      




    





















       
            
           
       


</main>


<br>
<br>

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
    // JavaScript function to reload the page every 30 seconds
    setTimeout(function() {
        location.reload();
    }, 30000); // 30 seconds (30,000 milliseconds)
</script>







<script>
  const editIcon = document.getElementById('edit-icon');
const formContainer = document.getElementById('formContainer');

// Add click event listener to toggle visibility without layout shifting
editIcon.addEventListener('click', function() {
    formContainer.classList.toggle('show');
});
</script>

<script>
document.getElementById('profile-pic').addEventListener('change', function() {
    const fileNameElement = document.getElementById('file-name');
    const fileName = this.files.length > 0 ? this.files[0].name : 'No file chosen';
    fileNameElement.textContent = fileName; // Update the text to show the selected file name
    fileNameElement.style.display = 'block'; // Show the file name when a file is chosen
});
</script>

<script>
document.getElementById("toggleBtn").addEventListener("click", function() {
    var div = document.getElementById("istorija_sakriveno");
    if (div.style.display === "none") {
        div.style.display = "block";
        this.textContent = "Sakrij istoriju"; // Menja tekst dugmeta
    } else {
        div.style.display = "none";
        this.textContent = "Prikaži istoriju"; // Menja tekst dugmeta nazad
    }
});
</script>

<script>
    function openPopup() {
        var popup = document.getElementById('popup');
        if (popup.style.display === 'block') {
            popup.style.display = 'none';
        } else {
            popup.style.display = 'block';
        }
    }
</script>

</body>

</html>