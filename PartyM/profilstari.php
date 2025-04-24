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

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="./assets/css/styleprofil.css">

<link rel="stylesheet" href="./assets/css/demo.css">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">


  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="./assets/css/profil.css" rel="stylesheet">

  

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<style>
  




.card {
    background: rgba(0, 0, 0, 0.12);
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 0;
    margin-bottom: 1rem;
}
.reservation {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 20px;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.reservation p {
    color: #333;
    line-height: 1.6;
}




.reservation .status {
    font-weight: bold;
    color: white; /* Green for available or confirmed statuses, you can change this based on the status */
}
.djlikeslika{
  width: 70px;
  margin-left: 20px;
  margin-right: 20px;
  border-radius: 10%;
}
.custom-link {
    color: black; /* A more visually appealing blue */
    text-decoration: none; /* Removes the underline */
     /* Makes the link text bold */
    transition: color 0.3s ease, text-decoration 0.3s ease; /* Smooth transition effects */
    
}

.custom-link:hover {
    color: #0056b3; /* Darker blue on hover */
    text-decoration: underline; /* Underline appears on hover */
}

.dj{
 
            background: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
            backdrop-filter: blur(10px); /* Blur effect */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow for depth */
            border: 1px solid rgba(255, 255, 255, 0.3); /* Light border */
           
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            font-size: 1.2em;
            padding: 20px;
            box-sizing: border-box;
}


.blink {
    animation: blink-animation 3s infinite;
    border-radius: 10%;
}

@keyframes blink-animation {
    0%   { opacity: 1; color: black;  }
    50%  { opacity: 0.7; color: #F87515;  }
    100% { opacity: 1; color: black;  }
}



.istorijatabela-container table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    font-size: 14px;
}

.istorijatabela-container th,
.istorijatabela-container td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: left;
}

.istorijatabela-container th {
    font-weight: bold;
}

.istorijatabela-container {
  
   
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease-out;
}

.istorijatabela-container.expanded {
    max-height: 1000px; /* Large enough to fit the table */
    transition: max-height 0.6s ease-in;
    max-width: 100%;
}






.toggle-dugme {
    background-color: #4b137d; /* Main site color */
    color: #ffffff;
    padding: 12px 24px;
    font-size: 1em;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    outline: none;
}

.toggle-dugme:hover {
    background-color: #3d1067; /* Darker shade for hover effect */
}

.toggle-dugme:active {
    transform: scale(0.98); /* Slight scale down on click for a pressed effect */
}

.toggle-dugme:focus {
    outline: 2px solid #b08fcf; /* Subtle focus outline for accessibility */
}

.form-container {
    display: flex;              /* Use flexbox */
    justify-content: center;    /* Center horizontally */
    align-items: center;        /* Center vertically */
    opacity: 0;
    max-height: 0;
    overflow: hidden;
    transition: opacity 0.3s ease, max-height 0.3s ease;
             
}

.form-container.show {
    opacity: 1;
    max-height: 500px; /* Adjust as needed for your form's height */
}

.upload-form {
    display: flex;
    flex-direction: column;
    align-items: center;        /* Center items horizontally */
    gap: 10px;                 /* Space between elements */
    width: 250px;              /* Set a fixed width */
    padding: 20px;             /* Add some padding for aesthetics */
   
}

.custom-file-upload {
    display: inline-block;
    cursor: pointer;
    background-color: #4b137d; /* Change this to your desired color */
    color: white;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    transition: background-color 0.3s ease; /* Smooth transition */
}

.custom-file-upload:hover {
    background-color: #3a0e65; /* Darker shade on hover */
}

.upload-form input[type="file"] {
    display: none; /* Hide the default file input */
}

.upload-form button {
    background-color: #4b137d; /* Change this to your desired color */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease; /* Smooth transition */
}

.upload-form button:hover {
    background-color: #3a0e65; /* Darker shade on hover */
}

.file-name {
    display: none; /* Initially hidden */
    margin-top: 10px; /* Add some space above the text */
    color: white; /* Optional: change the color of the text */
}









.profile-head {
    transform: translateY(5rem)
}

.cover {
    background-image: url(https://images.unsplash.com/photo-1530305408560-82d13781b33a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1352&q=80);
    background-size: cover;
    background-repeat: no-repeat
}


#star {
            margin-left: -5px !important;
            vertical-align: bottom !important;
            opacity: 0.5;
        }


        .more {
            opacity: 0.5 !important;
        }

        .btn:hover {
            color: black !important;
        }

        .vl {
            margin: 8px !important;
            width: 2px;
            border-right: 1px solid #aaaaaa;
            height: 25px;
        }


        #plus {
            opacity: 0.8;
        }


        .card {
            border-radius: 10px !important;
            padding-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card-body{
            font-style: normal;
           
        }

        .linkovi:hover {
            background-color: #ccc !important;
        }



        .btn-outlined:active {
            color: #FFF;
            border-color: #fff !important;
        }


        .img {

            cursor: pointer;
            overflow: visible;
        }

        .btn:focus,
        .btn:active {
            outline: none !important;
            box-shadow: none !important;
        }

        
.btn-outline-dark:hover{
    background-color: #aaaaaa;
}


.didzejevi {
    display: flex;
    align-items: center;
    background-color: #f8f8f8;
    padding: 10px;
    border-radius: 6px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    max-width: 220px;
    margin: 10px auto;
    gap: 10px; /* Space between image and link */
}

.djlikeslika {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    transition: transform 0.2s ease;
}

.custom-link {
    font-size: 1rem;
    color: #4b137d;
    font-weight: bold;
    text-decoration: none;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.dj {
    display: none;
}

/* Hover effects */
.djlikeslika:hover {
    transform: scale(1.05); /* Subtle zoom on hover */
}

.custom-link:hover {
    color: #822dbf;
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

  
     








     


 


















      




    



<div class="row py-1 px-3"> 
    <div class="col-md-5 mx-auto"> <!-- Profile widget --> 
        <div class="bg-white shadow rounded overflow-hidden"> 
            <div class="px-4 pt-0 pb-4 cover"> 
                <div class="media align-items-end profile-head"> 
                    <div class="profile mr-3">
                        <img src="<?php echo htmlspecialchars($profile_pic_url); ?>" style="width: 150px; height: 150px; object-fit: cover;border-radius: 50%;" class="mb-2">
                        <a  class="btn btn-outline-dark btn-sm btn-block" id="edit-icon" onclick="toggleEditIcon()">Edit profile</a>
                    </div> 
                    <div class="media-body mb-5 text-white"> 
                        <h4 class="mt-0 mb-0"><?php echo $userime; ?></h4> 
                        <p class="small mb-4"> <i class="fas fa-map-marker-alt mr-2"></i><?php echo $message; ?></p> 
                        
                    </div> 
                </div> 
            </div> 
            <div class="bg-light p-4 d-flex justify-content-end text-center">
                <ul class="list-inline mb-0"> 
                    <!-- <li class="list-inline-item"> 
                        <h5 class="font-weight-bold mb-0 d-block">5</h5><small class="text-muted"> <i class="fas fa-image mr-1"></i>Dj</small>
                    </li>  -->
                    <li class="list-inline-item"> <h5 class="font-weight-bold mb-0 d-block"><?php echo $bodovi; ?></h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Passes</small>
                </li> 
                 <li class="list-inline-item"> <h5 class="font-weight-bold mb-0 d-block">340</h5><small class="text-muted"> <i class="fas fa-user mr-1"></i>Following</small> 
                 </li> </ul> 
            </div> 

            <div class="form-container" id="formContainer">
    <form action="process_upload.php" method="POST" enctype="multipart/form-data" class="upload-form">
        <label for="profile-pic" class="custom-file-upload">
            <input type="file" id="profile-pic" name="profile_pic" accept="image/*" required>
            Choose a file
        </label>
        <p id="file-name" class="file-name" style="display: none;color:black; font-size: 10px;">No file chosen</p> <!-- Initially hidden -->
        <button type="submit">Upload</button>
    </form>
</div>












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
                












        <div class="px-2 py-1"> 
            <div class="d-flex align-items-center justify-content-between mb-3"> 
                <h5 class="mb-0">Istorija Rezervacija</h5>
                <a id='toggleTableBtn' class="btn btn-link text-muted" style="text-decoration:underline">Show all</a> 
            </div> 


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


// SQL query to fetch data from the tocionicaistorija table for the given user ID
$sql = "SELECT * FROM tocionicaistorija WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    echo "<div class='istorijatabela-container'>";
    echo "<table border='1'>";
    echo "<tr>
  <th>Mesto:</th>
  <th>Datum:</th>
  <th>Vreme Dolaska:</th>
  <th>Vrsta Rezervacije</th>
  </tr>";
  while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>";
      if ($row['mesto'] === 'tocionica') {
        echo "Точионица Паб";
    } 
     else {
        echo "Bag... ";
    }
    echo "</td>";
      echo "<td>" . $row["zadatum"] . "</td>";
      echo "<td>" . $row["vremedolaska"] . "</td>";
      echo "<td>" . $row["vrstarez"] . "</td>";
      echo "</tr>";
  }
  echo "</table>";
  echo "</div>";
} else {
  echo "<p style='color: white'>Nemate potvrdjenih rezervacija.</p>";
}
$conn->close();
?>
<hr>
        </div> 
        <div class="px-2 py-1"> 
            <div class="d-flex align-items-center justify-content-between mb-3"> 
                <h5 class="mb-0">Pratim</h5>  
            </div> 
           <div class="didzejevi">
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

 // Query to check if user has liked any DJs
 $sql = "SELECT * FROM mikula WHERE user_id = ?";
 
 // Prepare the statement
 $stmt = $conn->prepare($sql);
 $stmt->bind_param("i", $_SESSION["user_id"]);
 
 // Execute the query
 $stmt->execute();
 
 // Get the result
 $result = $stmt->get_result();
 
 // Check if there are any rows returned
 if ($result->num_rows > 0) {
  
  echo '<img src="./assets/img/djj.jpg" alt="" class="djlikeslika"/>';
  echo '<a href="./djs/mikula.php" class="custom-link">Mikula</a>';
  
} else {
  echo '<div class="dj" style="display: none;"></div>'; // Hide the div.dj if no DJs liked
}

 // Close the database connection
 $conn->close();
 
?>
</div>
        </div>
        
    </div> 
</div>
</div>

</div>
</div>
</div>

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
  document.getElementById('toggleTableBtn').addEventListener('click', function() {
    var tableContainer = document.querySelector('.istorijatabela-container');
    if (tableContainer.classList.contains('expanded')) {
        tableContainer.classList.remove('expanded');
        this.textContent = "Show All";
    } else {
        tableContainer.classList.add('expanded');
        this.textContent = "Hide All";
    }
});
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